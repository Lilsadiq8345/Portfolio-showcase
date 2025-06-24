<template>
  <div class="max-w-lg mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-blue-900">Add New Project</h2>
    <form @submit.prevent="handleAddProject">
      <div class="mb-4">
        <label class="block text-gray-700 mb-1">Title</label>
        <input v-model="title" type="text" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400" />
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 mb-1">Description</label>
        <textarea v-model="description" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"></textarea>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 mb-1">URL</label>
        <input v-model="url" type="url" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400" />
      </div>
      <div class="mb-6">
        <label class="block text-gray-700 mb-1">Image (optional)</label>
        <input @change="onFileChange" type="file" accept="image/*" class="w-full" />
      </div>
      <button type="submit" :disabled="loading" class="w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800 font-semibold disabled:opacity-50">
        <span v-if="loading">Adding...</span>
        <span v-else>Add Project</span>
      </button>
      <div v-if="success" class="mt-4 text-green-600">Project added successfully!</div>
      <div v-if="error" class="mt-4 text-red-600">{{ error }}</div>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import apiService from '../../services/ApiService';

const title = ref('');
const description = ref('');
const url = ref('');
const image = ref(null);
const loading = ref(false);
const success = ref(false);
const error = ref('');

const onFileChange = (e) => {
  image.value = e.target.files[0];
};

const handleAddProject = async () => {
  loading.value = true;
  success.value = false;
  error.value = '';
  try {
    const formData = new FormData();
    formData.append('title', title.value);
    formData.append('description', description.value);
    formData.append('url', url.value);
    if (image.value) {
      formData.append('image', image.value);
    }
    await apiService.post('/api/admin/projects', formData, {
      headers: { 'Content-Type': 'multipart/form-data' },
    });
    success.value = true;
    title.value = '';
    description.value = '';
    url.value = '';
    image.value = null;
  } catch (err) {
    error.value = err.response?.data?.message || 'Failed to add project.';
  } finally {
    loading.value = false;
  }
};
</script> 