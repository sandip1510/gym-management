<!-- resources/js/Layouts/AuthLayout.vue -->
<template>
  <div class="min-h-screen flex bg-gray-50">
    <!-- Sidebar -->
    <aside class="w-56 bg-white border-r p-4 hidden md:block">
      <div class="mb-6">
        <h2 class="font-semibold text-lg">Admin Panel</h2>
      </div>

      <nav class="space-y-2">
        <router-link to="/admin" class="block px-2 py-2 rounded hover:bg-gray-100">Dashboard</router-link>
        <router-link to="/admin/users" class="block px-2 py-2 rounded hover:bg-gray-100">Users</router-link>
        <router-link to="/admin/plans" class="block px-2 py-2 rounded hover:bg-gray-100">Plans</router-link>
        <router-link to="/admin/subscriptions" class="block px-2 py-2 rounded hover:bg-gray-100">Subscriptions</router-link>
        <router-link to="/admin/attendances" class="block px-2 py-2 rounded hover:bg-gray-100">Attendance</router-link>
      </nav>
    </aside>

    <!-- Main area -->
    <div class="flex-1 flex flex-col">
      <Header />
      <main class="p-6">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import Header from "@/Components/Header.vue";
</script>
