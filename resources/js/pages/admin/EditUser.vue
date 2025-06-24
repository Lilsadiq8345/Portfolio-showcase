<template>
  <div class="max-w-lg mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-blue-900">Edit User</h2>
    <form @submit.prevent="handleEditUser">
      <div class="mb-4">
        <label class="block text-gray-700 mb-1">Name</label>
        <input v-model="name" type="text" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400" />
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 mb-1">Email</label>
        <input v-model="email" type="email" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400" />
      </div>
      <div class="mb-6">
        <label class="block text-gray-700 mb-1">Role</label>
        <select v-model="role" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>
      </div>
      <button type="submit" :disabled="loading" class="w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800 font-semibold disabled:opacity-50">
        <span v-if="loading">Updating...</span>
        <span v-else>Update User</span>
      </button>
      <div v-if="success" class="mt-4 text-green-600">User updated successfully!</div>
      <div v-if="error" class="mt-4 text-red-600">{{ error }}</div>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import apiService from '../../services/ApiService';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();
const userId = route.params.id;
const name = ref('');
const email = ref('');
const role = ref('user');
const loading = ref(false);
const success = ref(false);
const error = ref('');

const fetchUser = async () => {
  try {
    const res = await apiService.get('/admin/users');
    const user = res.data.users.find(u => u.id == userId);
    if (user) {
      name.value = user.name;
      email.value = user.email;
      role.value = user.is_admin ? 'admin' : 'user';
    }
  } catch (err) {
    error.value = 'Failed to fetch user.';
  }
};

const handleEditUser = async () => {
  loading.value = true;
  success.value = false;
  error.value = '';
  try {
    await apiService.put(`/admin/users/${userId}`, {
      name: name.value,
      email: email.value,
      role: role.value,
    });
    success.value = true;
  } catch (err) {
    error.value = err.response?.data?.message || 'Failed to update user.';
  } finally {
    loading.value = false;
  }
};

onMounted(fetchUser);
</script> 