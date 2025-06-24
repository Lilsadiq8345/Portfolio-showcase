<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-900">
    <div class="flex w-full max-w-4xl bg-gray-800 rounded-xl shadow-lg overflow-hidden">
      <!-- Left: Login Form -->
      <div class="w-full md:w-1/2 p-8 flex flex-col justify-center bg-gray-900">
        <div class="flex flex-col items-center mb-8">
          <img src="/logo.png" alt="Sparktro Logo" class="h-16 mb-4" />
          <h1 class="text-3xl font-bold text-white mb-2">We are The Sparktro Team</h1>
          <p class="text-gray-300 text-center">Please login to your account</p>
        </div>
        <form @submit.prevent="handleLogin" class="space-y-6">
          <div>
            <input
              v-model="email"
              type="email"
              placeholder="Email"
              required
              class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-pink-400"
            />
          </div>
          <div>
            <input
              v-model="password"
              type="password"
              placeholder="Password"
              required
              class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-pink-400"
            />
          </div>
          <div v-if="errorMessage" class="text-sm text-red-400 text-center">
            {{ errorMessage }}
          </div>
          <button
            type="submit"
            class="w-full py-2 font-bold text-white rounded-md bg-gradient-to-r from-orange-500 to-pink-500 hover:from-pink-500 hover:to-orange-500 transition"
          >
            LOG IN
          </button>
        </form>
        <div class="flex justify-between items-center mt-4">
          <router-link to="/forgot-password" class="text-sm text-gray-400 hover:underline">Forgot password?</router-link>
        </div>
        <div class="mt-8 text-center">
          <span class="text-gray-300">Don't have an account?</span>
          <router-link to="/register" class="ml-2 px-4 py-2 border border-pink-400 text-pink-400 rounded hover:bg-pink-400 hover:text-white transition font-semibold">CREATE NEW</router-link>
        </div>
      </div>
      <!-- Right: Company Info -->
      <div class="hidden md:flex w-1/2 flex-col justify-center items-center bg-gradient-to-br from-orange-500 via-pink-500 to-purple-600 p-10">
        <h2 class="text-2xl font-bold text-white mb-4">We are more than just a company</h2>
        <p class="text-white text-lg mb-6 max-w-xs">
          Sparktro is your full-scale software partner. We build scalable, innovative web, mobile, AI, and cloud solutions tailored for startups, enterprises, and visionaries. Our team blends passion, innovation, and discipline in every line of code.
        </p>
        <p class="text-white text-sm">Learn more at <a href="https://sparktro.com/" target="_blank" class="underline hover:text-orange-200">sparktro.com</a></p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import apiService from '../services/apiService';
import authService from '../services/authService';

const email = ref('');
const password = ref('');
const errorMessage = ref('');
const router = useRouter();

const handleLogin = async () => {
  errorMessage.value = '';
  try {
    await apiService.get('/sanctum/csrf-cookie');
    const response = await apiService.post('/login', {
      email: email.value,
      password: password.value,
    });
    
    const { token, user } = response.data;
    authService.login(token, user);
    
    // Redirect to dashboard
    router.push({ name: 'Dashboard' });

  } catch (error) {
    if (error.response && error.response.status === 422) {
      errorMessage.value = 'Invalid credentials. Please try again.';
    } else {
      errorMessage.value = 'An unexpected error occurred. Please try again later.';
    }
    console.error('Login failed:', error);
  }
};
</script>
 