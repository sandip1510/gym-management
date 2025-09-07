<template>
  <button
    @click="goBack"
    class="inline-flex items-center gap-2 px-3 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800"
  >
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
      <path fill-rule="evenodd" d="M12.707 15.707a1 1 0 01-1.414 0L5.586 10l5.707-5.707a1 1 0 011.414 1.414L8.414 10l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
    </svg>
    <span>Back</span>
  </button>
</template>

<script setup>
import { useRouter } from "vue-router";
const router = useRouter();

function goBack() {
  // prefer history back, fallback to root
  if (window.history.length > 1) router.back();
  else router.push("/");
}
</script>

<style scoped></style>
