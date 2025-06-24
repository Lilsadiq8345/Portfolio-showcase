<template>
  <nav class="bg-white shadow text-gray-800 px-8 py-4 flex items-center justify-between">
    <div class="flex items-center space-x-2">
      <span class="text-2xl font-bold tracking-wide text-blue-700">PortfolioShowcase</span>
    </div>
    <ul class="flex items-center space-x-8">
      <li><router-link to="/dashboard" class="hover:text-blue-600">Home</router-link></li>
      <li><router-link to="/projects" class="hover:text-blue-600">Projects</router-link></li>
      <li><router-link to="/profile" class="hover:text-blue-600">Profile</router-link></li>
      <li><button @click="logout" class="bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded text-white font-semibold">Logout</button></li>
    </ul>
  </nav>
</template>

<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

function logout() {
  // Clear token and redirect to login
  localStorage.removeItem('token');
  router.push('/login');
}
</script> 