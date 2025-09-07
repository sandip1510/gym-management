<template>
  <aside
    class="fixed left-0 top-0 h-full w-64 bg-white text-slate-900 border-r shadow-sm z-40 flex flex-col"
    aria-label="Sidebar"
  >
    <!-- Brand -->
    <div class="h-16 flex items-center px-6 border-b">
      <div class="flex items-center gap-3">
        <div class="text-2xl">🏋️</div>
        <div class="text-lg font-semibold">Gym Management</div>
      </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-4 space-y-2" role="navigation" aria-label="Main navigation">
      <RouterLink
        v-for="item in items"
        :key="item.name"
        :to="item.to"
        class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-100 transition"
        :class="{ 'bg-gray-100 font-semibold': isActive(item.to) }"
      >
        <span class="w-6 h-6 flex-none" aria-hidden="true" v-html="item.icon" />
        <span>{{ item.name }}</span>
      </RouterLink>
    </nav>

    <!-- Footer -->
    <div class="p-4 border-t">
      <div class="text-sm text-slate-600">Signed in as</div>
      <div class="mt-1 font-medium truncate">{{ user?.name || 'User' }}</div>

      <div class="mt-3 flex gap-2">
        <button @click="$emit('goProfile')" class="flex-1 px-3 py-1 rounded-md border">
          Profile
        </button>
        <button
          @click="$emit('logout')"
          class="px-3 py-1 rounded-md bg-red-600 text-white hover:bg-red-700"
        >
          Logout
        </button>
      </div>
    </div>
  </aside>
</template>

<script setup>
import { computed } from "vue";
import { useRoute, RouterLink } from "vue-router";

/*
  Icons are inline SVG strings. No external dependency required.
  If you prefer lucide/icons later we can switch easily.
*/
const ICONS = {
  home: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 fill-current"><path d="M3 11.5V21a1 1 0 001 1h5v-7h4v7h5a1 1 0 001-1V11.5l-8-6.5-8 6.5z"/></svg>`,
  users: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 fill-current"><path d="M16 11c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm-8 0c1.657 0 3-1.343 3-3S9.657 5 8 5 5 6.343 5 8s1.343 3 3 3zM4 17v1a1 1 0 001 1h14a1 1 0 001-1v-1c0-2.761-4-4-8-4s-8 1.239-8 4z"/></svg>`,
  box: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 fill-current"><path d="M21 8l-9-5-9 5v8a2 2 0 002 2h14a2 2 0 002-2V8zM12 3.1L18.6 7 12 10.9 5.4 7 12 3.1zM4 9.3l7 3.9v6.3L4 15.6V9.3zM13 19.5v-6.3l7-3.9v6.3l-7 3.9z"/></svg>`,
  card: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 fill-current"><path d="M3 7a2 2 0 012-2h14a2 2 0 012 2v2H3V7zm0 4h18v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6z"/></svg>`,
  attendance: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 fill-current"><path d="M19 3h-1V1h-2v2H8V1H6v2H5a2 2 0 00-2 2v15a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zM9.5 17.5L6 14l1.4-1.4 2.1 2.1L16.6 7 18 8.4 9.5 17.5z"/></svg>`,
};

const items = [
  { name: "Dashboard", to: "/admin", icon: ICONS.home },
  { name: "Users", to: "/admin/users", icon: ICONS.users },
  { name: "Plans", to: "/admin/plans", icon: ICONS.box },
  { name: "Subscriptions", to: "/admin/subscriptions", icon: ICONS.card },
  { name: "Attendance", to: "/admin/attendance", icon: ICONS.attendance },
];

defineEmits(["logout", "goProfile"]);
defineProps({ open: { type: Boolean, default: true } });

const route = useRoute();
const isActive = (to) => route.path === to || route.path.startsWith(to + "/");

const user = computed(() => {
  try {
    const raw = localStorage.getItem("user");
    return raw ? JSON.parse(raw) : null;
  } catch {
    return null;
  }
});
</script>

<style scoped>
/* ensure SVGs inherit the text color */
svg.fill-current { color: inherit; }
</style>
