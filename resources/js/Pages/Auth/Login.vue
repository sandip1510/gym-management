<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
      <h2 class="text-2xl font-bold text-center mb-6">Login</h2>

      <form @submit.prevent="login">
        <input v-model="email" type="email" placeholder="Email"
               class="w-full mb-3 px-3 py-2 border rounded"/>
        <input v-model="password" type="password" placeholder="Password"
               class="w-full mb-3 px-3 py-2 border rounded"/>
        
        <p v-if="error" class="text-red-600 mb-2">{{ error }}</p>

        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">
          Login
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref } from "vue";
import { useRouter } from "vue-router";

const email = ref("");
const password = ref("");
const error = ref("");
const router = useRouter();

const login = async () => {
  try {
    const res = await axios.post("/api/auth/login", {
      email: email.value,
      password: password.value
    });

    if (res.data.status === "success") {
      const { token, user, roles } = res.data.data;

      localStorage.setItem("token", token);
      localStorage.setItem("user", JSON.stringify(user));
      localStorage.setItem("roles", JSON.stringify(roles));

      // redirect based on role
      if (roles.includes("admin")) router.push("/admin");
      else if (roles.includes("trainer")) router.push("/trainer");
      else router.push("/member");
    } else {
      error.value = res.data.message || "Invalid credentials";
    }

  } catch (e) {
    console.error("Login error:", e);
    error.value = "Invalid credentials";
  }
};
</script>
