<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">
      <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Sparktro</h1>
        <p class="text-gray-600">Create a new account</p>
      </div>
      <form @submit.prevent="handleRegister">
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
            <span v-if="loading">Registering...</span>
            <span v-else>Register</span>
          </button>
        </div>
        <div class="mt-4 text-center">
          <router-link to="/login" class="text-sm text-blue-600 hover:underline">
            Already have an account? Login
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
// ... existing code ...
</script> 