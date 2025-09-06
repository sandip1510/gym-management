import { ref } from "vue";

export const authStore = {
  user: ref(JSON.parse(localStorage.getItem("user") || "null")),
  token: ref(localStorage.getItem("token") || null),
  roles: ref(JSON.parse(localStorage.getItem("roles") || "[]")),

  login(user, token, roles) {
    this.user.value = user;
    this.token.value = token;
    this.roles.value = Array.isArray(roles) ? roles : (roles ? [roles] : []);
    localStorage.setItem("user", JSON.stringify(user));
    localStorage.setItem("token", token);
    localStorage.setItem("roles", JSON.stringify(this.roles.value));
    console.log("[authStore] login ->", { user: this.user.value, roles: this.roles.value });
  },

  logout() {
    this.user.value = null;
    this.token.value = null;
    this.roles.value = [];
    localStorage.removeItem("user");
    localStorage.removeItem("token");
    localStorage.removeItem("roles");
    console.log("[authStore] logout");
  }
};
