import { createRouter, createWebHistory } from "vue-router";

// Pages
import Login from "./Pages/Auth/Login.vue";
import AdminDashboard from "./Pages/Admin/Dashboard.vue";
import TrainerDashboard from "./Pages/Trainer/Dashboard.vue";
import MemberDashboard from "./Pages/Member/Dashboard.vue";

// Admin
import Users from "./Pages/Admin/Users.vue";
import Plans from "./Pages/Admin/Plans.vue";
import Subscriptions from "./Pages/Admin/Subscriptions.vue";
import Attendances from "./Pages/Admin/Attendances.vue";
import Pages from "./Pages/Admin/Pages.vue";

const routes = [
  { path: "/login", component: Login, meta: { guest: true } },
  { path: "/admin", component: AdminDashboard, meta: { requiresAuth: true, roles: ["admin"] } },
  { path: "/trainer", component: TrainerDashboard, meta: { requiresAuth: true, roles: ["trainer"] } },
  { path: "/member", component: MemberDashboard, meta: { requiresAuth: true, roles: ["member"] } },

  // Admin
    { path: "/admin", component: AdminDashboard, meta: { requiresAuth: true, roles: ["admin"] } },
  { path: "/admin/users", component: Users, meta: { requiresAuth: true, roles: ["admin"] } },
  { path: "/admin/plans", component: Plans, meta: { requiresAuth: true, roles: ["admin"] } },
  { path: "/admin/subscriptions", component: Subscriptions, meta: { requiresAuth: true, roles: ["admin"] } },
  { path: "/admin/attendances", component: Attendances, meta: { requiresAuth: true, roles: ["admin"] } },
  { path: "/admin/pages", component: Pages, meta: { requiresAuth: true, roles: ["admin"] } },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// 👮 Navigation guard
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem("token");
  const roles = JSON.parse(localStorage.getItem("roles") || "[]");

  if (to.meta.requiresAuth && !token) {
    return next("/login"); // not logged in
  }

  if (to.meta.roles && roles.length > 0) {
    const allowed = to.meta.roles.some((r) => roles.includes(r));
    if (!allowed) {
      return next("/login"); // not allowed role
    }
  }

  if (to.meta.guest && token) {
    // already logged in → redirect
    if (roles.includes("admin")) return next("/admin");
    if (roles.includes("trainer")) return next("/trainer");
    return next("/member");
  }

  next();
});

export default router;
