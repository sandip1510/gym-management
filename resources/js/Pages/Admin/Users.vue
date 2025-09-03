<template>
  <AppLayout>
    <h2 class="text-2xl font-bold mb-4">Manage Users</h2>

    <!-- Search -->
    <input v-model="search" @input="fetchUsers" type="text"
           placeholder="🔍 Search users..."
           class="border p-2 mb-4 w-full rounded" />

    <!-- Add/Edit Form -->
    <form @submit.prevent="saveUser" class="mb-6 bg-gray-100 p-4 rounded shadow">
      <div class="flex gap-2">
        <input v-model="form.name" type="text" placeholder="Name" class="border p-2 flex-1 rounded" />
        <input v-model="form.email" type="email" placeholder="Email" class="border p-2 flex-1 rounded" />
        <input v-model="form.password" type="password" placeholder="Password" class="border p-2 flex-1 rounded" />
        <select v-model="form.role" class="border p-2 flex-1 rounded">
          <option disabled value="">Select role</option>
          <option value="admin">Admin</option>
          <option value="trainer">Trainer</option>
          <option value="member">Member</option>
        </select>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
          {{ form.id ? 'Update' : 'Add' }}
        </button>
      </div>
    </form>

    <!-- Users Table -->
    <div class="overflow-x-auto bg-white rounded shadow">
      <table class="w-full border-collapse">
        <thead>
          <tr class="bg-gray-200 text-left">
            <th class="p-2 border">Name</th>
            <th class="p-2 border">Email</th>
            <th class="p-2 border">Role</th>
            <th class="p-2 border text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-50">
            <td class="p-2 border">{{ user.name }}</td>
            <td class="p-2 border">{{ user.email }}</td>
            <td class="p-2 border">
              <span class="px-2 py-1 text-sm rounded bg-green-100 text-green-700">
                {{ user.roles?.[0]?.name || 'N/A' }}
              </span>
            </td>
            <td class="p-2 border text-center">
              <button @click="editUser(user)" class="text-blue-600 hover:underline">✏️</button>
              <button @click="deleteUser(user.id)" class="text-red-600 hover:underline ml-2">🗑</button>
            </td>
          </tr>
          <tr v-if="!users.data.length">
            <td colspan="4" class="p-3 text-center text-gray-500">No users found</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-between items-center mt-4">
      <button :disabled="!users.prev_page_url" @click="fetchUsers(users.current_page - 1)"
              class="px-3 py-1 bg-gray-200 rounded disabled:opacity-50">⬅ Prev</button>
      <span>Page {{ users.current_page }} of {{ users.last_page }}</span>
      <button :disabled="!users.next_page_url" @click="fetchUsers(users.current_page + 1)"
              class="px-3 py-1 bg-gray-200 rounded disabled:opacity-50">Next ➡</button>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import AppLayout from "@/Layouts/AppLayout.vue";

const users = ref({ data: [] });
const form = ref({ id: null, name: "", email: "", password: "", role: "" });
const search = ref("");

const fetchUsers = async (page = 1) => {
  const res = await axios.get(`/api/admin/users?page=${page}&search=${search.value}`, {
    headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
  });
  users.value = res.data;
};

const saveUser = async () => {
  const endpoint = form.value.id
    ? `/api/admin/users/${form.value.id}`
    : `/api/admin/users`;

  const method = form.value.id ? "put" : "post";

  await axios[method](endpoint, form.value, {
    headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
  });

  form.value = { id: null, name: "", email: "", password: "", role: "" };
  fetchUsers();
};

const editUser = (user) => {
  form.value = { id: user.id, name: user.name, email: user.email, password: "", role: user.roles?.[0]?.name };
};

const deleteUser = async (id) => {
  if (confirm("Are you sure?")) {
    await axios.delete(`/api/admin/users/${id}`, {
      headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
    });
    fetchUsers();
  }
};

onMounted(fetchUsers);
</script>
