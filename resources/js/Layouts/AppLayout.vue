<template>
  <div class="min-h-screen flex flex-col bg-gray-100">
    <!-- Navbar -->
    <header class="bg-white shadow p-4 flex justify-between items-center">
      <h1 class="font-bold text-xl">🏋️ Gym Management</h1>
      <button
        @click="logout"
        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded"
      >
        Logout
      </button>
    </header>

    <!-- Main content -->
    <main class="flex-1 p-6">
      <slot />
    </main>
  </div>
</template>

<script setup>
import axios from "axios";
import { useRouter } from "vue-router";

const router = useRouter();

const logout = async () => {
  try {
    const token = localStorage.getItem("token");
    if (token) {
      await axios.post(
        "/api/auth/logout",
        {},
        { headers: { Authorization: `Bearer ${token}` } }
      );
    }
  } catch (e) {
    console.warn("Logout failed, clearing local storage anyway.");
  }

  // Clear session
  localStorage.removeItem("token");
  localStorage.removeItem("user");
  localStorage.removeItem("roles");

  router.push("/login");
};
</script>
