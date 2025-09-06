<script setup>
import { authStore } from "@/store/auth";
import { useRouter } from "vue-router";

const router = useRouter();

const logout = () => {
  authStore.logout();
  router.push("/login");
};
</script>

<template>
  <div id="layout">
    <header class="p-4 bg-gray-800 text-white flex justify-between">
      <h1 class="font-bold">🏋️ Gym Management</h1>

      <nav v-if="!authStore.token">
        <router-link to="/login" class="px-2">Login</router-link>
        <router-link to="/register" class="px-2">Register</router-link>
      </nav>

      <nav v-else>
        <span class="mr-4">Welcome, {{ authStore.user?.name }}</span>
        <button
          @click="logout"
          class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded"
        >
          Logout
        </button>
      </nav>
    </header>

    <main class="p-6">
      <router-view />
    </main>
  </div>
</template>
