<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const plans = ref([]);
const form = ref({ name: "", price: "", duration_days: "" });
const editing = ref(null);

const fetchPlans = async () => {
  const res = await axios.get("/api/admin/plans");
  plans.value = res.data;
};

const savePlan = async () => {
  if (editing.value) {
    await axios.put(`/api/admin/plans/${editing.value}`, form.value);
  } else {
    await axios.post("/api/admin/plans", form.value);
  }
  form.value = { name: "", price: "", duration_days: "" };
  editing.value = null;
  fetchPlans();
};

const editPlan = (plan) => {
  form.value = { ...plan };
  editing.value = plan.id;
};

const deletePlan = async (id) => {
  await axios.delete(`/api/admin/plans/${id}`);
  fetchPlans();
};

onMounted(fetchPlans);
</script>

<template>
  <div class="p-6">
    <h2 class="text-xl font-bold mb-4">Membership Plans</h2>

    <form @submit.prevent="savePlan" class="mb-6 space-y-2">
      <input v-model="form.name" placeholder="Plan Name" class="border p-2 w-full" />
      <input v-model="form.price" placeholder="Price" type="number" class="border p-2 w-full" />
      <input v-model="form.duration_days" placeholder="Duration (days)" type="number" class="border p-2 w-full" />
      <button class="bg-green-600 text-white px-4 py-2 rounded">
        {{ editing ? "Update" : "Create" }} Plan
      </button>
    </form>

    <table class="w-full border">
      <thead class="bg-gray-100">
        <tr>
          <th class="border p-2">Name</th>
          <th class="border p-2">Price</th>
          <th class="border p-2">Duration</th>
          <th class="border p-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="p in plans" :key="p.id">
          <td class="border p-2">{{ p.name }}</td>
          <td class="border p-2">{{ p.price }}</td>
          <td class="border p-2">{{ p.duration_days }}</td>
          <td class="border p-2 space-x-2">
            <button @click="editPlan(p)" class="px-2 py-1 bg-yellow-500 text-white">Edit</button>
            <button @click="deletePlan(p.id)" class="px-2 py-1 bg-red-600 text-white">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
