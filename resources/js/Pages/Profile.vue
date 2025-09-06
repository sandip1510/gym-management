<template>
  <div>
    <h2 class="text-2xl font-bold mb-4">Profile</h2>
    <div v-if="user">
      <p><strong>Name:</strong> {{ user.name }}</p>
      <p><strong>Email:</strong> {{ user.email }}</p>
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue";
import { authStore } from "@/stores/auth";

const user = computed(() => authStore.user.value);
</script>
