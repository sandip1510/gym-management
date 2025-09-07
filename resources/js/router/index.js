import { createRouter, createWebHistory } from 'vue-router';

// Layout
import AppLayout from '../Layouts/AppLayout.vue';

// Admin pages
import Users from '../Pages/Admin/Users.vue';
import Plans from '../Pages/Admin/Plans.vue';

// Example: a Dashboard component
import Dashboard from '../Pages/Admin/Dashboard.vue';

const routes = [
  {
    path: '/admin',
    component: AppLayout,
    children: [
      { path: '', name: 'admin.dashboard', component: Dashboard },
      { path: 'users', name: 'admin.users', component: Users },
      { path: 'plans', name: 'admin.plans', component: Plans },
    ],
  },
  // Auth
  { path: '/login', component: () => import('../Pages/Auth/Login.vue') },
  { path: '/register', component: () => import('../Pages/Auth/Register.vue') },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
