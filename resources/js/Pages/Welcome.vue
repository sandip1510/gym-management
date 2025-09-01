<template>
  <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
    <div class="text-center max-w-xl">
      <!-- Logo -->
      <h1 class="text-3xl font-bold mb-4">🏋️ Gym Management System</h1>
      <p class="text-gray-600 mb-6">
        Manage your gym with ease — track members, trainers, subscriptions, and attendance.
      </p>

      <!-- Buttons -->
      <div class="flex gap-4 justify-center">
        <a
          href="/login"
          class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow"
        >
          Login
        </a>
        <a
          href="/register"
          class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded shadow"
        >
          Register
        </a>
      </div>
    </div>
  </div>
</template>

<script setup>
// nothing needed for now
</script>
