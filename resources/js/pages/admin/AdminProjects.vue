<template>
  <div class="max-w-4xl mx-auto bg-white p-8 rounded shadow">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 space-y-2 md:space-y-0">
      <input v-model="search" type="text" placeholder="Search projects..." class="border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400" />
      <router-link to="/admin/projects/add" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800">Add Project</router-link>
    </div>
    <table class="min-w-full divide-y divide-gray-200">
      <thead>
        <tr>
          <th class="px-4 py-2">Title</th>
          <th class="px-4 py-2">Description</th>
          <th class="px-4 py-2">URL</th>
          <th class="px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="project in paginatedProjects" :key="project.id" class="hover:bg-gray-50">
          <td class="px-4 py-2">{{ project.title }}</td>
          <td class="px-4 py-2">{{ project.description }}</td>
          <td class="px-4 py-2"><a :href="project.url" target="_blank" class="text-blue-600 hover:underline">View</a></td>
          <td class="px-4 py-2 space-x-2">
            <router-link :to="`/admin/projects/edit/${project.id}`" class="text-blue-600 hover:underline">Edit</router-link>
            <button @click="confirmDelete(project)" class="text-red-600 hover:underline">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="flex justify-between items-center mt-4">
      <div class="text-sm text-gray-600">Showing {{ startIdx + 1 }}-{{ endIdx }} of {{ filteredProjects.length }} projects</div>
      <div class="space-x-2">
        <button @click="prevPage" :disabled="page === 1" class="px-3 py-1 rounded bg-gray-200 disabled:opacity-50">Prev</button>
        <button @click="nextPage" :disabled="endIdx >= filteredProjects.length" class="px-3 py-1 rounded bg-gray-200 disabled:opacity-50">Next</button>
      </div>
    </div>
    <div v-if="error" class="mt-4 text-red-600">{{ error }}</div>
    <div v-if="showConfirm" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-30 z-50">
      <div class="bg-white p-6 rounded shadow">
        <p>Are you sure you want to delete <b>{{ projectToDelete?.title }}</b>?</p>
        <div class="mt-4 flex justify-end space-x-2">
          <button @click="showConfirm = false" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
          <button @click="deleteProject" class="px-4 py-2 bg-red-600 text-white rounded">Delete</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed, watch } from 'vue';
import apiService from '../../services/ApiService';
import { useRouter } from 'vue-router';

const projects = ref([]);
const error = ref('');
const showConfirm = ref(false);
const projectToDelete = ref(null);
const router = useRouter();
const search = ref('');
const page = ref(1);
const perPage = 10;

const filteredProjects = computed(() => {
  let result = projects.value;
  if (search.value) {
    const s = search.value.toLowerCase();
    result = result.filter(p => p.title.toLowerCase().includes(s));
  }
  return result;
});

const startIdx = computed(() => (page.value - 1) * perPage);
const endIdx = computed(() => Math.min(page.value * perPage, filteredProjects.value.length));
const paginatedProjects = computed(() => filteredProjects.value.slice(startIdx.value, endIdx.value));

function nextPage() {
  if (endIdx.value < filteredProjects.value.length) page.value++;
}
function prevPage() {
  if (page.value > 1) page.value--;
}
watch(search, () => { page.value = 1; });

const fetchProjects = async () => {
  try {
    const res = await apiService.get('/admin/projects');
    projects.value = res.data.projects;
  } catch (err) {
    error.value = 'Failed to fetch projects.';
  }
};

const confirmDelete = (project) => {
  projectToDelete.value = project;
  showConfirm.value = true;
};

const deleteProject = async () => {
  try {
    await apiService.delete(`/admin/projects/${projectToDelete.value.id}`);
    projects.value = projects.value.filter(p => p.id !== projectToDelete.value.id);
    showConfirm.value = false;
    projectToDelete.value = null;
  } catch (err) {
    error.value = 'Failed to delete project.';
  }
};

onMounted(fetchProjects);
</script> 