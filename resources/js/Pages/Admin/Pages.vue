<template>
  <AppLayout>
    <div class="flex justify-between mb-4">
      <h2 class="text-2xl font-bold">Manage CMS Pages</h2>
      <input v-model="search" @input="fetchPages"
             placeholder="Search by title..."
             class="border px-3 py-2 rounded w-64"/>
    </div>

    <!-- Add/Edit Page -->
    <form @submit.prevent="savePage" class="mb-6 bg-gray-100 p-4 rounded grid gap-2">
      <input v-model="form.title" type="text" placeholder="Page Title" class="border p-2"/>
      <textarea v-model="form.content" placeholder="Page Content"
                class="border p-2 h-24"></textarea>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
        {{ form.id ? 'Update' : 'Add' }}
      </button>
    </form>

    <!-- Pages Table -->
    <table class="w-full border">
      <thead class="bg-gray-200">
        <tr>
          <th class="p-2 border">Title</th>
          <th class="p-2 border">Content</th>
          <th class="p-2 border">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="pg in pages.data" :key="pg.id">
          <td class="p-2 border font-bold">{{ pg.title }}</td>
          <td class="p-2 border truncate max-w-sm">{{ pg.content }}</td>
          <td class="p-2 border">
            <button @click="editPage(pg)" class="bg-yellow-500 text-white px-2 py-1 mr-2">Edit</button>
            <button @click="deletePage(pg.id)" class="bg-red-600 text-white px-2 py-1">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination -->
    <div class="flex justify-between mt-4">
      <button :disabled="!pages.prev_page_url" @click="changePage(pages.current_page - 1)"
              class="px-3 py-1 border rounded">Prev</button>
      <span>Page {{ pages.current_page }} of {{ pages.last_page }}</span>
      <button :disabled="!pages.next_page_url" @click="changePage(pages.current_page + 1)"
              class="px-3 py-1 border rounded">Next</button>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import AppLayout from "@/Layouts/AppLayout.vue";

const pages = ref({ data: [] });
const form = ref({ id: null, title: "", content: "" });
const search = ref("");
const page = ref(1);

const fetchPages = async () => {
  const res = await axios.get("/api/admin/pages", {
    params: { search: search.value, page: page.value },
    headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
  });
  pages.value = res.data;
};

const savePage = async () => {
  if (form.value.id) {
    await axios.put(`/api/admin/pages/${form.value.id}`, form.value, {
      headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
    });
  } else {
    await axios.post("/api/admin/pages", form.value, {
      headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
    });
  }
  form.value = { id: null, title: "", content: "" };
  fetchPages();
};

const editPage = (pg) => {
  form.value = { id: pg.id, title: pg.title, content: pg.content };
};

const deletePage = async (id) => {
  if (confirm("Delete this page?")) {
    await axios.delete(`/api/admin/pages/${id}`, {
      headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
    });
    fetchPages();
  }
};

const changePage = (p) => { page.value = p; fetchPages(); };

onMounted(fetchPages);
</script>
