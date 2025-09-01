import { createRouter, createWebHistory } from 'vue-router';

import Users from '../Pages/Admin/Users.vue';
import Plans from '../Pages/Admin/Plans.vue';

const routes = [
  { path: '/admin/users', component: Users },
  { path: '/admin/plans', component: Plans },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
