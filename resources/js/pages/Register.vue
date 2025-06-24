<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md p-6 sm:p-8 space-y-6 bg-white rounded-lg shadow-md">
      <h1 class="text-2xl font-bold text-center text-gray-800">Create an Account</h1>
      <form @submit.prevent="handleRegister" class="space-y-6">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Username</label>
          <input
            v-model="name"
            type="text"
            id="name"
            required
            class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          />
        </div>
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
          <input
            v-model="email"
            type="email"
            id="email"
            required
            class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          />
        </div>
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <input
            v-model="password"
            type="password"
            id="password"
            required
            class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          />
        </div>
        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
          <input
            v-model="password_confirmation"
            type="password"
            id="password_confirmation"
            required
            class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          />
        </div>
        <div v-if="errorMessage" class="text-sm text-red-600">
          {{ errorMessage }}
        </div>
        <div>
          <button
            type="submit"
            class="w-full px-4 py-2 font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            Register
          </button>
        </div>
      </form>
      <p class="text-sm text-center text-gray-600">
        Already have an account?
        <router-link to="/login" class="font-medium text-indigo-600 hover:text-indigo-500">
          Login here
        </router-link>
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import apiService from '../services/apiService';
import authService from '../services/authService';

const name = ref('');
const email = ref('');
const password = ref('');
const password_confirmation = ref('');
const errorMessage = ref('');
const router = useRouter();

const handleRegister = async () => {
  errorMessage.value = '';
  if (password.value !== password_confirmation.value) {
    errorMessage.value = 'Passwords do not match.';
    return;
  }

  try {
    const response = await apiService.post('/register', {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value,
    });
    
    // Use the authService to log the user in
    const { token, user } = response.data;
    authService.login(token, user);
    
    // Redirect to dashboard
    router.push({ name: 'Dashboard' });

  } catch (error) {
    if (error.response && error.response.data) {
        // Concatenate validation errors
        const errors = Object.values(error.response.data).flat();
        errorMessage.value = errors.join(' ');
    } else {
      errorMessage.value = 'An unexpected error occurred. Please try again later.';
    }
    console.error('Registration failed:', error);
  }
};
</script>