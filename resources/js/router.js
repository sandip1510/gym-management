// resources/js/router.js
import { createRouter, createWebHistory } from "vue-router";

import Login from "./Pages/Auth/Login.vue";
import Register from "./Pages/Auth/Register.vue";

import AdminDashboard from "./Pages/Admin/Dashboard.vue";
import Users from "./Pages/Admin/Users.vue";
import Plans from "./Pages/Admin/Plans.vue";
import Subscriptions from "./Pages/Admin/Subscriptions.vue";
import Attendances from "./Pages/Admin/Attendances.vue";

import TrainerDashboard from "./Pages/Trainer/Dashboard.vue";
import MemberDashboard from "./Pages/Member/Dashboard.vue";
import Profile from "./Pages/Profile.vue";

const routes = [
  { path: "/", redirect: "/login" },

  // Guest pages
  { path: "/login", component: Login, meta: { layout: "guest", guest: true } },
  { path: "/register", component: Register, meta: { layout: "guest", guest: true } },

  // Authenticated pages (use auth layout)
  { path: "/admin", component: AdminDashboard, meta: { layout: "auth", requiresAuth: true, roles: ["admin"] } },
  { path: "/admin/users", component: Users, meta: { layout: "auth", requiresAuth: true, roles: ["admin"] } },
  { path: "/admin/plans", component: Plans, meta: { layout: "auth", requiresAuth: true, roles: ["admin"] } },
  { path: "/admin/subscriptions", component: Subscriptions, meta: { layout: "auth", requiresAuth: true, roles: ["admin"] } },
  { path: "/admin/attendances", component: Attendances, meta: { layout: "auth", requiresAuth: true, roles: ["admin"] } },

  { path: "/trainer", component: TrainerDashboard, meta: { layout: "auth", requiresAuth: true, roles: ["trainer"] } },
  { path: "/member", component: MemberDashboard, meta: { layout: "auth", requiresAuth: true, roles: ["member"] } },

  { path: "/profile", component: Profile, meta: { layout: "auth", requiresAuth: true } },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// navigation guard (token+roles)
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem("token");
  const roles = JSON.parse(localStorage.getItem("roles") || "[]");

  if (to.meta.requiresAuth && !token) return next("/login");

  if (to.meta.roles && to.meta.roles.length > 0) {
    const allowed = to.meta.roles.some((r) => roles.includes(r));
    if (!allowed) return next("/login");
  }

  if (to.meta.guest && token) {
    // logged in users shouldn't see guest pages
    if (roles.includes("admin")) return next("/admin");
    if (roles.includes("trainer")) return next("/trainer");
    return next("/member");
  }

  return next();
});

export default router;
