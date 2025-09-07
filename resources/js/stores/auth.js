// resources/js/stores/auth.js
import { defineStore } from "pinia";
import axios from "axios";

export const useAuthStore = defineStore("auth", {
  state: () => ({
    user: JSON.parse(localStorage.getItem("user")) || null,
    token: localStorage.getItem("token") || null,
  }),

  getters: {
    isLoggedIn: (state) => !!state.token,
  },

  actions: {
    setSession(user, token) {
      this.user = user;
      this.token = token;
      localStorage.setItem("user", JSON.stringify(user));
      localStorage.setItem("token", token);
      axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
    },

    clearSession() {
      this.user = null;
      this.token = null;
      localStorage.removeItem("user");
      localStorage.removeItem("token");
      delete axios.defaults.headers.common["Authorization"];
    },

    async login(credentials) {
      const { data } = await axios.post("/api/auth/login", credentials);
      this.setSession(data.user, data.token);
      return data;
    },

    async logout() {
      try {
        if (this.token) {
          await axios.post(
            "/api/auth/logout",
            {},
            { headers: { Authorization: `Bearer ${this.token}` } }
          );
        }
      } catch (e) {
        console.warn("Logout request failed — clearing local session", e);
      } finally {
        this.clearSession();
      }
    },
  },
});
