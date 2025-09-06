<!-- resources/js/Layouts/GuestLayout.vue -->
<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-md w-full">
      <div class="text-center mb-6">
        <h1 class="text-3xl font-bold">🏋️ Gym Management</h1>
        <p class="text-sm text-gray-600">Login or register to manage the gym.</p>
      </div>

      <div class="bg-white p-6 rounded shadow">
        <slot />
      </div>
    </div>
  </div>
</template>

<script setup>
// nothing required
</script>
