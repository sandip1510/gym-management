<template>
  <div id="layout">
    <!-- Global Navbar (optional) -->
    <header class="p-4 bg-gray-800 text-white flex justify-between">
      <h1 class="font-bold">🏋️ Gym Management</h1>
      <nav>
        <router-link to="/login" class="px-2">Login</router-link>
        <router-link to="/register" class="px-2">Register</router-link>
      </nav>
    </header>

    <!-- Route content -->
    <main class="p-6">
      <router-view />
    </main>
  </div>
</template>

<script setup>
// nothing needed for now
</script>

<style>
body {
  margin: 0;
  font-family: sans-serif;
}
</style>
