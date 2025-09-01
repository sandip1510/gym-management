<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

function submit() {
  form.post('/register')
}
</script>

<template>
  <div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-green-500 to-teal-600">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md">
      <h1 class="text-3xl font-bold text-green-600 text-center mb-6">Create Account</h1>
      <form @submit.prevent="submit" class="space-y-4">
        <input v-model="form.name" placeholder="Full Name" class="w-full p-2 border rounded-lg" />
        <input v-model="form.email" type="email" placeholder="Email" class="w-full p-2 border rounded-lg" />
        <input v-model="form.password" type="password" placeholder="Password" class="w-full p-2 border rounded-lg" />
        <input v-model="form.password_confirmation" type="password" placeholder="Confirm Password" class="w-full p-2 border rounded-lg" />
        <button class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">Register</button>
      </form>
      <p class="text-center text-sm text-gray-500 mt-4">
        Already have an account?
        <Link href="/login" class="text-green-600 hover:underline">Login</Link>
      </p>
    </div>
  </div>
</template>
