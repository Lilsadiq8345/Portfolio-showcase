<template>
  <div class="max-w-lg mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-blue-900">Add New User</h2>
    <form @submit.prevent="handleAddUser">
      <div class="mb-4">
        <label class="block text-gray-700 mb-1">Name</label>
        <input v-model="name" type="text" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400" />
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 mb-1">Email</label>
        <input v-model="email" type="email" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400" />
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 mb-1">Password</label>
        <input v-model="password" type="password" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400" />
      </div>
      <div class="mb-6">
        <label class="block text-gray-700 mb-1">Role</label>
        <select v-model="role" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>
      </div>
      <button type="submit" :disabled="loading" class="w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800 font-semibold disabled:opacity-50">
        <span v-if="loading">Adding...</span>
        <span v-else>Add User</span>
      </button>
      <div v-if="success" class="mt-4 text-green-600">User added successfully!</div>
      <div v-if="error" class="mt-4 text-red-600">{{ error }}</div>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import apiService from '../../services/ApiService';

const name = ref('');
const email = ref('');
const password = ref('');
const role = ref('user');
const loading = ref(false);
const success = ref(false);
const error = ref('');

const handleAddUser = async () => {
  loading.value = true;
  success.value = false;
  error.value = '';
  try {
    await apiService.post('/api/admin/users', {
      name: name.value,
      email: email.value,
      password: password.value,
      role: role.value,
    });
    success.value = true;
    name.value = '';
    email.value = '';
    password.value = '';
    role.value = 'user';
  } catch (err) {
    error.value = err.response?.data?.message || 'Failed to add user.';
  } finally {
    loading.value = false;
  }
};
</script> 