<template>
  <div>
    <h2 class="text-2xl font-bold mb-4">Profile</h2>

    <div v-if="user">
      <p><strong>Name:</strong> {{ user.name }}</p>
      <p><strong>Email:</strong> {{ user.email }}</p>
    </div>

    <div v-else>
      <p class="text-sm text-gray-500">No profile available.</p>
    </div>
  </div>
</template>

<script setup>
import { reactive, computed } from "vue";
import { getActivePinia } from "pinia";
import axios from "axios";

// reactive container for template
const userState = reactive({
  name: null,
  email: null,
  avatar: null,
});

// If Pinia is active, use the store; otherwise fallback to localStorage
if (getActivePinia()) {
  // dynamic import to avoid module-eval-time store calls
  // top-level await is supported in modern Vue setups / Vite
  const { useAuthStore } = await import("@/stores/auth");
  const auth = useAuthStore();
  // populate reactive object from store (keeps reactivity)
  userState.name = auth.user?.name ?? null;
  userState.email = auth.user?.email ?? null;
  userState.avatar = auth.user?.avatar ?? null;
} else {
  // fallback: localStorage read (safe)
  try {
    const raw = localStorage.getItem("user");
    if (raw) {
      const parsed = JSON.parse(raw);
      userState.name = parsed.name ?? null;
      userState.email = parsed.email ?? null;
      userState.avatar = parsed.avatar ?? null;
    }
    const token = localStorage.getItem("token");
    if (token) axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
  } catch (e) {
    console.warn("Profile: failed to read user from localStorage", e);
  }
}

const user = computed(() => (userState.name ? userState : null));
</script>

<style scoped></style>
