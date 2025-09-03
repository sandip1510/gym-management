<template>
  <AppLayout>
    <div class="p-6">
      <h1 class="text-3xl font-bold mb-4">Admin Dashboard</h1>
      <p class="mb-6 text-gray-600">Welcome, Admin! 🎉 Manage everything from here.</p>

      <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
        <router-link to="/admin/users" class="block bg-white shadow rounded-lg p-6 hover:shadow-md">
          <h2 class="font-semibold text-lg">👤 Users</h2>
          <p class="text-gray-500 text-sm">Manage gym members, trainers, and admins.</p>
        </router-link>

        <router-link to="/admin/plans" class="block bg-white shadow rounded-lg p-6 hover:shadow-md">
          <h2 class="font-semibold text-lg">📦 Plans</h2>
          <p class="text-gray-500 text-sm">Define membership plans & pricing.</p>
        </router-link>

        <router-link to="/admin/subscriptions" class="block bg-white shadow rounded-lg p-6 hover:shadow-md">
          <h2 class="font-semibold text-lg">💳 Subscriptions</h2>
          <p class="text-gray-500 text-sm">Assign plans to members.</p>
        </router-link>

        <router-link to="/admin/attendances" class="block bg-white shadow rounded-lg p-6 hover:shadow-md">
          <h2 class="font-semibold text-lg">📝 Attendance</h2>
          <p class="text-gray-500 text-sm">Track who is coming in/out.</p>
        </router-link>

        <router-link to="/admin/pages" class="block bg-white shadow rounded-lg p-6 hover:shadow-md">
          <h2 class="font-semibold text-lg">📄 Pages</h2>
          <p class="text-gray-500 text-sm">Manage CMS content pages.</p>
        </router-link>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
</script>
