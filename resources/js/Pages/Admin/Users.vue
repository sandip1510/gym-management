<template>
  <AppLayout>
    <h2 class="text-2xl font-bold mb-4">Manage Users</h2>

    <!-- Add User Form -->
    <form @submit.prevent="saveUser" class="mb-6 bg-gray-100 p-4 rounded">
      <input v-model="form.name" type="text" placeholder="Name" class="border p-2 mr-2" />
      <input v-model="form.email" type="email" placeholder="Email" class="border p-2 mr-2" />
      <input v-model="form.password" type="password" placeholder="Password" class="border p-2 mr-2" />
      <select v-model="form.role" class="border p-2 mr-2">
        <option disabled value="">Select role</option>
        <option value="admin">Admin</option>
        <option value="trainer">Trainer</option>
        <option value="member">Member</option>
      </select>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
        {{ form.id ? 'Update' : 'Add' }}
      </button>
    </form>

    <!-- Users Table -->
    <table class="w-full border">
      <thead>
        <tr class="bg-gray-200">
          <th class="p-2 border">Name</th>
          <th class="p-2 border">Email</th>
          <th class="p-2 border">Role</th>
          <th class="p-2 border">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td class="p-2 border">{{ user.name }}</td>
          <td class="p-2 border">{{ user.email }}</td>
          <td class="p-2 border">{{ user.roles?.[0]?.name || 'N/A' }}</td>
          <td class="p-2 border">
            <button @click="editUser(user)" class="bg-yellow-500 text-white px-2 py-1 mr-2">Edit</button>
            <button @click="deleteUser(user.id)" class="bg-red-600 text-white px-2 py-1">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </AppLayout>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import AppLayout from "@/Layouts/AppLayout.vue";

const users = ref([]);
const form = ref({ id: null, name: "", email: "", password: "", role: "" });

const fetchUsers = async () => {
  const res = await axios.get("/api/admin/users", {
    headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
  });
  users.value = res.data;
};

const saveUser = async () => {
  try {
    if (form.value.id) {
      await axios.put(`/api/admin/users/${form.value.id}`, form.value, {
        headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
      });
    } else {
      await axios.post("/api/admin/users", form.value, {
        headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
      });
    }
    form.value = { id: null, name: "", email: "", password: "", role: "" };
    fetchUsers();
  } catch (e) {
    console.error(e);
  }
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
