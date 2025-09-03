<template>
  <AppLayout>
    <div class="flex justify-between mb-4">
      <h2 class="text-2xl font-bold">Manage Subscriptions</h2>
      <input v-model="search" @input="fetchSubs"
             placeholder="Search by user..."
             class="border px-3 py-2 rounded w-64"/>
    </div>

    <!-- Add/Edit Subscription -->
    <form @submit.prevent="saveSub" class="mb-6 bg-gray-100 p-4 rounded grid grid-cols-4 gap-2">
      <input v-model="form.user_id" type="number" placeholder="User ID" class="border p-2"/>
      <input v-model="form.plan_id" type="number" placeholder="Plan ID" class="border p-2"/>
      <input v-model="form.start_date" type="date" class="border p-2"/>
      <input v-model="form.end_date" type="date" class="border p-2"/>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded col-span-4">
        {{ form.id ? 'Update' : 'Add' }}
      </button>
    </form>

    <!-- Table -->
    <table class="w-full border">
      <thead class="bg-gray-200">
        <tr>
          <th class="p-2 border">User</th>
          <th class="p-2 border">Plan</th>
          <th class="p-2 border">Start</th>
          <th class="p-2 border">End</th>
          <th class="p-2 border">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="sub in subs.data" :key="sub.id">
          <td class="p-2 border">{{ sub.user?.name }}</td>
          <td class="p-2 border">{{ sub.plan?.name }}</td>
          <td class="p-2 border">{{ sub.start_date }}</td>
          <td class="p-2 border">{{ sub.end_date }}</td>
          <td class="p-2 border">
            <button @click="editSub(sub)" class="bg-yellow-500 text-white px-2 py-1 mr-2">Edit</button>
            <button @click="deleteSub(sub.id)" class="bg-red-600 text-white px-2 py-1">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination -->
    <div class="flex justify-between mt-4">
      <button :disabled="!subs.prev_page_url" @click="changePage(subs.current_page - 1)"
              class="px-3 py-1 border rounded">Prev</button>
      <span>Page {{ subs.current_page }} of {{ subs.last_page }}</span>
      <button :disabled="!subs.next_page_url" @click="changePage(subs.current_page + 1)"
              class="px-3 py-1 border rounded">Next</button>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import AppLayout from "@/Layouts/AppLayout.vue";

const subs = ref({ data: [] });
const form = ref({ id: null, user_id: "", plan_id: "", start_date: "", end_date: "" });
const search = ref("");
const page = ref(1);

const fetchSubs = async () => {
  const res = await axios.get("/api/admin/subscriptions", {
    params: { search: search.value, page: page.value },
    headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
  });
  subs.value = res.data;
};

const saveSub = async () => {
  if (form.value.id) {
    await axios.put(`/api/admin/subscriptions/${form.value.id}`, form.value, {
      headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
    });
  } else {
    await axios.post("/api/admin/subscriptions", form.value, {
      headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
    });
  }
  form.value = { id: null, user_id: "", plan_id: "", start_date: "", end_date: "" };
  fetchSubs();
};

const editSub = (sub) => {
  form.value = { id: sub.id, user_id: sub.user_id, plan_id: sub.plan_id, start_date: sub.start_date, end_date: sub.end_date };
};

const deleteSub = async (id) => {
  if (confirm("Delete this subscription?")) {
    await axios.delete(`/api/admin/subscriptions/${id}`, {
      headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
    });
    fetchSubs();
  }
};

const changePage = (p) => { page.value = p; fetchSubs(); };

onMounted(fetchSubs);
</script>
