<template>
  <header class="p-4 bg-gray-800 text-white flex justify-between items-center">
    <div class="flex items-center gap-3">
      <h1 class="font-bold text-lg">🏋️ Gym Management</h1>
      <span v-if="isAuthenticated" class="text-sm text-gray-200">• {{ roleLabel }}</span>
    </div>

    <nav class="flex items-center gap-3">
      <!-- Guest links -->
      <template v-if="!isAuthenticated">
        <router-link to="/login" class="px-2 hover:underline">Login</router-link>
        <router-link to="/register" class="px-2 hover:underline">Register</router-link>
      </template>

      <!-- Authenticated -->
      <template v-else>
        <span class="mr-4">Welcome, {{ authStore.user.value?.name || 'User' }}</span>

        <!-- Quick role links -->
        <router-link v-if="hasRole('admin')" to="/admin" class="px-2 hover:underline">Admin</router-link>
        <router-link v-if="hasRole('trainer')" to="/trainer" class="px-2 hover:underline">Trainer</router-link>
        <router-link v-if="hasRole('member')" to="/member" class="px-2 hover:underline">Member</router-link>

        <button @click="onLogout" class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-sm">
          Logout
        </button>
      </template>
    </nav>
  </header>
</template>

<script setup>
import { computed } from "vue";
import { useRouter } from "vue-router";
import { authStore } from "@/store/auth";

const router = useRouter();

const isAuthenticated = computed(() => !!authStore.token.value);

const hasRole = (r) => {
  return Array.isArray(authStore.roles.value) && authStore.roles.value.includes(r);
};

const roleLabel = computed(() => {
  if (hasRole("admin")) return "Admin";
  if (hasRole("trainer")) return "Trainer";
  if (hasRole("member")) return "Member";
  return "";
});

function onLogout() {
  authStore.logout();
  router.push("/login");
}
</script>

<style scoped>
/* optional small tweaks */
</style>
