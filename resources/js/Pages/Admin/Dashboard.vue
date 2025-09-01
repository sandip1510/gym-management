<template>
  <AppLayout>
    <h1 class="text-3xl font-bold mb-4">Admin Dashboard</h1>
    <p class="text-gray-600 mb-6">Welcome, Admin! 🎉 Manage everything here.</p>

    <div class="grid grid-cols-2 gap-6">
      <router-link to="/admin/users" class="block p-6 bg-white shadow rounded hover:bg-gray-50">
        👤 Manage Users
      </router-link>

      <router-link to="/admin/plans" class="block p-6 bg-white shadow rounded hover:bg-gray-50">
        📋 Membership Plans
      </router-link>

      <router-link to="/admin/subscriptions" class="block p-6 bg-white shadow rounded hover:bg-gray-50">
        💳 Subscriptions
      </router-link>

      <router-link to="/admin/attendances" class="block p-6 bg-white shadow rounded hover:bg-gray-50">
        📝 Attendance
      </router-link>

      <router-link to="/admin/pages" class="block p-6 bg-white shadow rounded hover:bg-gray-50">
        🌐 CMS Pages
      </router-link>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
</script>
