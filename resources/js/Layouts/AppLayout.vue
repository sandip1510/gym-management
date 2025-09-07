<template>
  <div class="min-h-screen bg-white text-black"> <!-- forced white bg + black text -->
    <!-- Mobile top bar -->
    <header class="lg:hidden flex items-center justify-between px-4 py-3 border-b bg-white">
      <button @click="toggleSidebar" aria-label="Open menu" class="p-2 rounded-md hover:bg-gray-100">
        <!-- Hamburger -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

      <div class="font-semibold">🏋️ Gym Management</div>

      <div class="flex items-center gap-3">
        <img v-if="user?.avatar" :src="user.avatar" class="w-8 h-8 rounded-full" alt="avatar" />
        <button @click="goProfile" class="p-2 rounded-md hover:bg-gray-100">👤</button>
      </div>
    </header>

    <!-- Sidebar -->
    <Sidebar :open="sidebarOpen" @logout="confirmLogout" @goProfile="goProfile" />

    <!-- Page content wrapper (push right on large screens) -->
    <div class="lg:pl-64 min-h-screen flex flex-col">
      <!-- Desktop top bar -->
      <header class="hidden lg:flex items-center justify-between bg-white shadow p-4">
        <div class="flex items-center gap-4">
          <h1 class="font-bold text-xl">🏋️ Gym Management</h1>
        </div>

        <div class="flex items-center gap-4">
          <div class="text-sm">Welcome, <span class="font-medium">{{ user?.name || "User" }}</span></div>
          <button @click="confirmLogout" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Logout</button>
        </div>
      </header>

      <!-- Main content -->
      <main class="flex-1 p-6 bg-white text-black"> <!-- ensure main is white + black -->
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from "vue";
import { useRouter } from "vue-router";
import Sidebar from "@/Components/Sidebar.vue";
import axios from "axios";

const sidebarOpen = ref(false);
const router = useRouter();

// read user from localStorage (quick dev-friendly fallback)
const user = reactive(JSON.parse(localStorage.getItem("user") || "null") || {});

// ensure axios has token header if present
const token = localStorage.getItem("token");
if (token) axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

function toggleSidebar() {
  sidebarOpen.value = !sidebarOpen.value;
}

function goProfile() {
  router.push("/profile");
  sidebarOpen.value = false;
}

async function confirmLogout() {
  // keep behavior similar to your existing flow
  const token = localStorage.getItem("token");
  try {
    if (token) {
      await axios.post("/api/auth/logout", {}, { headers: { Authorization: `Bearer ${token}` } });
    }
  } catch (e) {
    console.warn("Logout failed, clearing local storage anyway.");
  } finally {
    // Clear session and axios header
    localStorage.removeItem("token");
    localStorage.removeItem("user");
    localStorage.removeItem("roles");
    delete axios.defaults.headers.common["Authorization"];
    router.push("/login");
  }
}
</script>

<style scoped></style>
