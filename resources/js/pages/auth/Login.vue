<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">
      <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Sparktro</h1>
        <p class="text-gray-600">Login to your account</p>
      </div>
      <form @submit.prevent="handleLogin">
        <div class="mb-4">
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input id="email" v-model="email" type="email" required class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
        </div>
        <div class="mb-4">
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <input id="password" v-model="password" type="password" required class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
        </div>
        <div class="flex items-center justify-between mt-6">
          <button type="submit" :disabled="loading" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50">
            <span v-if="loading">Logging in...</span>
            <span v-else>Login</span>
          </button>
        </div>
        <div class="mt-4 text-center">
          <router-link to="/register" class="text-sm text-blue-600 hover:underline">
            Don't have an account? Register
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import apiService from '../../services/ApiService';

const router = useRouter();
const email = ref('');
const password = ref('');
const loading = ref(false);
const error = ref(null);

const handleLogin = async () => {
  loading.value = true;
  error.value = null;

  try {
    await apiService.get('/sanctum/csrf-cookie');
    const response = await apiService.post('/api/login', {
      email: email.value,
      password: password.value,
    });

    const { user, token } = response.data;
    localStorage.setItem('token', token);
    apiService.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    
    if (user.is_admin) {
      router.push('/admin/dashboard');
    } else {
      router.push('/dashboard');
    }
  } catch (err) {
    loading.value = false;
    if (err.response) {
      if (err.response.status === 401) {
        error.value = 'Invalid credentials. Please try again.';
      } else if (err.response.status === 422) {
        error.value = 'Validation failed. Please check your input.';
      } else {
        error.value = 'An unexpected error occurred. Please try again later.';
      }
    } else {
      error.value = 'Network error. Please check your connection.';
    }
    console.error('Login failed:', err);
  }
};
</script> 