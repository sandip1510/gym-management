
import { reactive } from "vue";

export const authStore = reactive({
  user: JSON.parse(localStorage.getItem("user") || "null"),
  token: localStorage.getItem("token") || null,
  roles: JSON.parse(localStorage.getItem("roles") || "[]"),

  login(user, token, roles) {
    this.user = user;
    this.token = token;
    this.roles = roles;

    localStorage.setItem("user", JSON.stringify(user));
    localStorage.setItem("token", token);
    localStorage.setItem("roles", JSON.stringify(roles));
  },

  logout() {
    this.user = null;
    this.token = null;
    this.roles = [];

    localStorage.removeItem("user");
    localStorage.removeItem("token");
    localStorage.removeItem("roles");
  },
});
