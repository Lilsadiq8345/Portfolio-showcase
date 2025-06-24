<template>
  <div class="max-w-4xl mx-auto bg-white p-8 rounded shadow">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 space-y-2 md:space-y-0">
      <div class="flex space-x-2">
        <input v-model="search" type="text" placeholder="Search users..." class="border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400" />
        <select v-model="roleFilter" class="border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
          <option value="">All Roles</option>
          <option value="admin">Admin</option>
          <option value="user">User</option>
        </select>
      </div>
      <router-link to="/admin/users/add" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800">Add User</router-link>
    </div>
    <table class="min-w-full divide-y divide-gray-200">
      <thead>
        <tr>
          <th class="px-4 py-2">Name</th>
          <th class="px-4 py-2">Email</th>
          <th class="px-4 py-2">Role</th>
          <th class="px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in paginatedUsers" :key="user.id" class="hover:bg-gray-50">
          <td class="px-4 py-2">{{ user.name }}</td>
          <td class="px-4 py-2">{{ user.email }}</td>
          <td class="px-4 py-2">
            <span v-if="user.is_admin" class="bg-yellow-400 text-blue-900 px-2 py-1 rounded text-xs font-semibold">Admin</span>
            <span v-else class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs">User</span>
          </td>
          <td class="px-4 py-2 space-x-2">
            <router-link :to="`/admin/users/edit/${user.id}`" class="text-blue-600 hover:underline">Edit</router-link>
            <button @click="confirmDelete(user)" class="text-red-600 hover:underline">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="flex justify-between items-center mt-4">
      <div class="text-sm text-gray-600">Showing {{ startIdx + 1 }}-{{ endIdx }} of {{ filteredUsers.length }} users</div>
      <div class="space-x-2">
        <button @click="prevPage" :disabled="page === 1" class="px-3 py-1 rounded bg-gray-200 disabled:opacity-50">Prev</button>
        <button @click="nextPage" :disabled="endIdx >= filteredUsers.length" class="px-3 py-1 rounded bg-gray-200 disabled:opacity-50">Next</button>
      </div>
    </div>
    <div v-if="error" class="mt-4 text-red-600">{{ error }}</div>
    <div v-if="showConfirm" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-30 z-50">
      <div class="bg-white p-6 rounded shadow">
        <p>Are you sure you want to delete <b>{{ userToDelete?.name }}</b>?</p>
        <div class="mt-4 flex justify-end space-x-2">
          <button @click="showConfirm = false" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
          <button @click="deleteUser" class="px-4 py-2 bg-red-600 text-white rounded">Delete</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed, watch } from 'vue';
import apiService from '../../services/ApiService';
import { useRouter } from 'vue-router';

const users = ref([]);
const error = ref('');
const showConfirm = ref(false);
const userToDelete = ref(null);
const router = useRouter();
const search = ref('');
const roleFilter = ref('');
const page = ref(1);
const perPage = 10;

const filteredUsers = computed(() => {
  let result = users.value;
  if (search.value) {
    const s = search.value.toLowerCase();
    result = result.filter(u => u.name.toLowerCase().includes(s) || u.email.toLowerCase().includes(s));
  }
  if (roleFilter.value) {
    result = result.filter(u => (roleFilter.value === 'admin' ? u.is_admin : !u.is_admin));
  }
  return result;
});

const startIdx = computed(() => (page.value - 1) * perPage);
const endIdx = computed(() => Math.min(page.value * perPage, filteredUsers.value.length));
const paginatedUsers = computed(() => filteredUsers.value.slice(startIdx.value, endIdx.value));

function nextPage() {
  if (endIdx.value < filteredUsers.value.length) page.value++;
}
function prevPage() {
  if (page.value > 1) page.value--;
}
watch([search, roleFilter], () => { page.value = 1; });

const fetchUsers = async () => {
  try {
    const res = await apiService.get('/api/admin/users');
    users.value = res.data.users;
  } catch (err) {
    error.value = 'Failed to fetch users.';
  }
};

const confirmDelete = (user) => {
  userToDelete.value = user;
  showConfirm.value = true;
};

const deleteUser = async () => {
  try {
    await apiService.delete(`/api/admin/users/${userToDelete.value.id}`);
    users.value = users.value.filter(u => u.id !== userToDelete.value.id);
    showConfirm.value = false;
    userToDelete.value = null;
  } catch (err) {
    error.value = 'Failed to delete user.';
  }
};

onMounted(fetchUsers);
</script> 