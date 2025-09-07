<template>
  <div>
    <div class="flex items-center justify-between mb-6">
      <BackButton />
      <h1 class="text-xl font-semibold">Profile</h1>
      <div />
    </div>

    <ProfileView />
  </div>
</template>

<script setup>
import BackButton from "@/Components/BackButton.vue";
import ProfileView from "@/Components/ProfileView.vue";
</script>

<style scoped></style>
