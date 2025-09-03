<template>
  <AppLayout>
    <div class="flex justify-between mb-4">
      <h2 class="text-2xl font-bold">Manage Attendance</h2>
      <input v-model="search" @input="fetchAttendances"
             placeholder="Search by user..."
             class="border px-3 py-2 rounded w-64"/>
    </div>

    <!-- Add/Edit Attendance -->
    <form @submit.prevent="saveAttendance" class="mb-6 bg-gray-100 p-4 rounded grid grid-cols-3 gap-2">
      <input v-model="form.user_id" type="number" placeholder="User ID" class="border p-2"/>
      <input v-model="form.date" type="date" class="border p-2"/>
      <select v-model="form.status" class="border p-2">
        <option value="present">Present</option>
        <option value="absent">Absent</option>
      </select>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded col-span-3">
        {{ form.id ? 'Update' : 'Add' }}
      </button>
    </form>

    <!-- Attendance Table -->
    <table class="w-full border">
      <thead class="bg-gray-200">
        <tr>
          <th class="p-2 border">User</th>
          <th class="p-2 border">Date</th>
          <th class="p-2 border">Status</th>
          <th class="p-2 border">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="att in attendances.data" :key="att.id">
          <td class="p-2 border">{{ att.user?.name }}</td>
          <td class="p-2 border">{{ att.date }}</td>
          <td class="p-2 border">
            <span :class="att.status === 'present' ? 'text-green-600' : 'text-red-600'">
              {{ att.status }}
            </span>
          </td>
          <td class="p-2 border">
            <button @click="editAttendance(att)" class="bg-yellow-500 text-white px-2 py-1 mr-2">Edit</button>
            <button @click="deleteAttendance(att.id)" class="bg-red-600 text-white px-2 py-1">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination -->
    <div class="flex justify-between mt-4">
      <button :disabled="!attendances.prev_page_url" @click="changePage(attendances.current_page - 1)"
              class="px-3 py-1 border rounded">Prev</button>
      <span>Page {{ attendances.current_page }} of {{ attendances.last_page }}</span>
      <button :disabled="!attendances.next_page_url" @click="changePage(attendances.current_page + 1)"
              class="px-3 py-1 border rounded">Next</button>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import AppLayout from "@/Layouts/AppLayout.vue";

const attendances = ref({ data: [] });
const form = ref({ id: null, user_id: "", date: "", status: "present" });
const search = ref("");
const page = ref(1);

const fetchAttendances = async () => {
  const res = await axios.get("/api/admin/attendances", {
    params: { search: search.value, page: page.value },
    headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
  });
  attendances.value = res.data;
};

const saveAttendance = async () => {
  if (form.value.id) {
    await axios.put(`/api/admin/attendances/${form.value.id}`, form.value, {
      headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
    });
  } else {
    await axios.post("/api/admin/attendances", form.value, {
      headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
    });
  }
  form.value = { id: null, user_id: "", date: "", status: "present" };
  fetchAttendances();
};

const editAttendance = (att) => {
  form.value = { id: att.id, user_id: att.user_id, date: att.date, status: att.status };
};

const deleteAttendance = async (id) => {
  if (confirm("Delete this record?")) {
    await axios.delete(`/api/admin/attendances/${id}`, {
      headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
    });
    fetchAttendances();
  }
};

const changePage = (p) => { page.value = p; fetchAttendances(); };

onMounted(fetchAttendances);
</script>
