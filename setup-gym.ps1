# setup-gym.ps1
# Auto generator for Gym Management App (Laravel 12 + Vue 3 SPA)

Write-Host "🏋️ Starting Gym Management App setup..."

# -------------------------
# CONFIG
# -------------------------
$ProjectName = "gym_app"
$DbName = "gym_management"

# -------------------------
# CREATE LARAVEL PROJECT
# -------------------------
Write-Host "📦 Installing Laravel..."
composer create-project laravel/laravel $ProjectName

Set-Location $ProjectName

# -------------------------
# INSTALL PACKAGES
# -------------------------
Write-Host "📦 Installing NPM dependencies..."
npm install vue@^3 vue-router@4 @vitejs/plugin-vue@^5.0.0 @tailwindcss/forms @tailwindcss/vite axios

Write-Host "📦 Installing Composer dependencies..."
composer require laravel/sanctum spatie/laravel-permission

# -------------------------
# SANCTUM SETUP
# -------------------------
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate

# -------------------------
# SPA SETUP
# -------------------------
Write-Host "📂 Setting up Vue + Tailwind..."
@"
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
});
"@ | Set-Content vite.config.js

# Tailwind config
npx tailwindcss init -p

@"
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.vue',
    './resources/**/*.js',
  ],
  theme: {
    extend: {},
  },
  plugins: [require('@tailwindcss/forms')],
}
"@ | Set-Content tailwind.config.js

# -------------------------
# APP.JS + ROUTER
# -------------------------
New-Item -ItemType Directory -Path "resources/js/Pages/Admin" -Force
New-Item -ItemType Directory -Path "resources/js/Pages/Trainer" -Force
New-Item -ItemType Directory -Path "resources/js/Pages/Member" -Force
New-Item -ItemType File -Path "resources/js/App.vue" -Force
New-Item -ItemType File -Path "resources/js/router.js" -Force
New-Item -ItemType File -Path "resources/js/Pages/Login.vue" -Force

# App.vue
@"
<template>
  <div id='layout'>
    <header class='p-4 bg-gray-800 text-white flex justify-between'>
      <h1 class='font-bold'>🏋️ Gym Management</h1>
      <nav>
        <router-link to='/login' class='px-2'>Login</router-link>
        <router-link to='/register' class='px-2'>Register</router-link>
      </nav>
    </header>
    <main class='p-6'>
      <router-view />
    </main>
  </div>
</template>
"@ | Set-Content resources/js/App.vue

# App.js
@"
import './bootstrap';
import '../css/app.css';
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';

createApp(App).use(router).mount('#app');
"@ | Set-Content resources/js/app.js

# Router.js
@"
import { createRouter, createWebHistory } from 'vue-router';
import Login from './Pages/Login.vue';
import AdminDashboard from './Pages/Admin/Dashboard.vue';
import TrainerDashboard from './Pages/Trainer/Dashboard.vue';
import MemberDashboard from './Pages/Member/Dashboard.vue';

const routes = [
  { path: '/login', component: Login },
  { path: '/admin', component: AdminDashboard, meta: { requiresAuth: true, roles: ['admin'] } },
  { path: '/trainer', component: TrainerDashboard, meta: { requiresAuth: true, roles: ['trainer'] } },
  { path: '/member', component: MemberDashboard, meta: { requiresAuth: true, roles: ['member'] } },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
"@ | Set-Content resources/js/router.js

# -------------------------
# AUTH CONTROLLER
# -------------------------
New-Item -ItemType Directory -Path "app/Http/Controllers/Admin" -Force
@"
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request \$request) {
        \$user = User::create([
            'name' => \$request->name,
            'email' => \$request->email,
            'password' => Hash::make(\$request->password),
        ]);
        \$user->assignRole('member');
        \$token = \$user->createToken('auth_token')->plainTextToken;
        return response()->json(['status'=>'success','data'=>['user'=>\$user,'roles'=>\$user->getRoleNames(),'token'=>\$token]]);
    }

    public function login(Request \$request) {
        \$user = User::where('email', \$request->email)->first();
        if (!\$user || !Hash::check(\$request->password, \$user->password)) {
            return response()->json(['status'=>'error','message'=>'Invalid credentials'],401);
        }
        \$token = \$user->createToken('auth_token')->plainTextToken;
        return response()->json(['status'=>'success','data'=>['user'=>\$user,'roles'=>\$user->getRoleNames(),'token'=>\$token]]);
    }
}
"@ | Set-Content app/Http/Controllers/AuthController.php

# -------------------------
# ZIP OUTPUT
# -------------------------
Set-Location ..
Compress-Archive -Path $ProjectName -DestinationPath "gym_app.zip" -Force

Write-Host "✅ Gym Management App created and zipped as gym_app.zip"
