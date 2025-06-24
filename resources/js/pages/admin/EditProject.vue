<template>
  <div class="max-w-lg mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-blue-900">Edit Project</h2>
    <form @submit.prevent="handleEditProject">
      <div class="mb-4">
        <label class="block text-gray-700 mb-1">Title</label>
        <input v-model="title" type="text" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400" />
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 mb-1">Description</label>
        <textarea v-model="description" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"></textarea>
      </div>
      <div class="mb-6">
        <label class="block text-gray-700 mb-1">URL</label>
        <input v-model="url" type="url" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400" />
      </div>
      <button type="submit" :disabled="loading" class="w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800 font-semibold disabled:opacity-50">
        <span v-if="loading">Updating...</span>
        <span v-else>Update Project</span>
      </button>
      <div v-if="success" class="mt-4 text-green-600">Project updated successfully!</div>
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
const projectId = route.params.id;
const title = ref('');
const description = ref('');
const url = ref('');
const loading = ref(false);
const success = ref(false);
const error = ref('');

const fetchProject = async () => {
  try {
    const res = await apiService.get('/admin/projects');
    const project = res.data.projects.find(p => p.id == projectId);
    if (project) {
      title.value = project.title;
      description.value = project.description;
      url.value = project.url;
    }
  } catch (err) {
    error.value = 'Failed to fetch project.';
  }
};

const handleEditProject = async () => {
  loading.value = true;
  success.value = false;
  error.value = '';
  try {
    await apiService.put(`/admin/projects/${projectId}`, {
      title: title.value,
      description: description.value,
      url: url.value,
    });
    success.value = true;
  } catch (err) {
    error.value = err.response?.data?.message || 'Failed to update project.';
  } finally {
    loading.value = false;
  }
};

onMounted(fetchProject);
</script> 