<template>
  <AppLayout>
    <div class="flex justify-between mb-4">
      <h2 class="text-2xl font-bold">Manage Plans</h2>
      <input v-model="search" @input="fetchPlans"
             placeholder="Search plans..."
             class="border px-3 py-2 rounded w-64"/>
    </div>

    <!-- Add/Edit Plan -->
    <form @submit.prevent="savePlan" class="mb-6 bg-gray-100 p-4 rounded flex gap-2">
      <input v-model="form.name" type="text" placeholder="Plan Name" class="border p-2 flex-1"/>
      <input v-model="form.price" type="number" placeholder="Price" class="border p-2 w-32"/>
      <input v-model="form.duration" type="number" placeholder="Duration (days)" class="border p-2 w-40"/>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
        {{ form.id ? 'Update' : 'Add' }}
      </button>
    </form>

    <!-- Plans Table -->
    <table class="w-full border">
      <thead class="bg-gray-200">
        <tr>
          <th class="p-2 border">Name</th>
          <th class="p-2 border">Price</th>
          <th class="p-2 border">Duration</th>
          <th class="p-2 border">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="plan in plans.data" :key="plan.id">
          <td class="p-2 border">{{ plan.name }}</td>
          <td class="p-2 border">₹{{ plan.price }}</td>
          <td class="p-2 border">{{ plan.duration }} days</td>
          <td class="p-2 border">
            <button @click="editPlan(plan)" class="bg-yellow-500 text-white px-2 py-1 mr-2">Edit</button>
            <button @click="deletePlan(plan.id)" class="bg-red-600 text-white px-2 py-1">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination -->
    <div class="flex justify-between mt-4">
      <button :disabled="!plans.prev_page_url" @click="changePage(plans.current_page - 1)"
              class="px-3 py-1 border rounded">Prev</button>
      <span>Page {{ plans.current_page }} of {{ plans.last_page }}</span>
      <button :disabled="!plans.next_page_url" @click="changePage(plans.current_page + 1)"
              class="px-3 py-1 border rounded">Next</button>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import AppLayout from "@/Layouts/AppLayout.vue";

const plans = ref({ data: [] });
const form = ref({ id: null, name: "", price: "", duration: "" });
const search = ref("");
const page = ref(1);

const fetchPlans = async () => {
  const res = await axios.get("/api/admin/plans", {
    params: { search: search.value, page: page.value },
    headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
  });
  plans.value = res.data;
};

const savePlan = async () => {
  if (form.value.id) {
    await axios.put(`/api/admin/plans/${form.value.id}`, form.value, {
      headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
    });
  } else {
    await axios.post("/api/admin/plans", form.value, {
      headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
    });
  }
  form.value = { id: null, name: "", price: "", duration: "" };
  fetchPlans();
};

const editPlan = (plan) => {
  form.value = { id: plan.id, name: plan.name, price: plan.price, duration: plan.duration };
};

const deletePlan = async (id) => {
  if (confirm("Delete this plan?")) {
    await axios.delete(`/api/admin/plans/${id}`, {
      headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
    });
    fetchPlans();
  }
};

const changePage = (p) => { page.value = p; fetchPlans(); };

onMounted(fetchPlans);
</script>
