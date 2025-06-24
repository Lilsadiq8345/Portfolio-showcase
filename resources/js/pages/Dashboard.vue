<template>
  <div class="container mx-auto p-4 md:p-8">
    <Toast v-if="toastMessage" :message="toastMessage" :type="toastType" />
    <header class="mb-8 flex justify-between items-center">
      <h1 class="text-3xl font-bold">Your Dashboard</h1>
      <button @click="openCreateModal" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Add New Project
      </button>
    </header>

    <!-- Projects Section -->
    <section>
      <h2 class="text-2xl font-semibold mb-4 border-b pb-2">My Projects</h2>
      <div v-if="loading" class="text-center">
        <p>Loading projects...</p>
      </div>
      <div v-else-if="error" class="text-center text-red-500">
        <p>{{ error }}</p>
      </div>
      <div v-else-if="projects.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="project in projects" :key="project.id" class="bg-white p-6 rounded-lg shadow-md flex flex-col justify-between">
          <div>
            <h3 class="text-xl font-bold mb-2">{{ project.title }}</h3>
            <p class="text-gray-700 mb-4">{{ project.description }}</p>
            <div class="mb-4">
              <span class="inline-block bg-green-100 text-green-800 text-sm font-semibold mr-2 px-2.5 py-0.5 rounded-full">{{ project.category }}</span>
              <span :class="project.visibility === 'public' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800'" class="text-sm font-semibold mr-2 px-2.5 py-0.5 rounded-full">{{ project.visibility }}</span>
            </div>
            <div class="flex justify-between items-center text-sm mb-4">
              <a :href="project.live_link" target="_blank" class="text-blue-500 hover:underline" v-if="project.live_link">Live Demo</a>
              <a :href="project.code_link" target="_blank" class="text-gray-500 hover:underline" v-if="project.code_link">Source Code</a>
            </div>
          </div>
          <div class="flex justify-end mt-auto pt-4 border-t border-gray-200">
            <button @click="openEditModal(project)" class="text-sm bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 mr-2">Edit</button>
            <button @click="confirmDelete(project.id)" class="text-sm bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
          </div>
        </div>
      </div>
      <div v-else>
        <p>You haven't added any projects yet. Add your first project below!</p>
      </div>
    </section>

    <!-- Modal for Create/Edit Project -->
    <Modal :show="showModal" @close="closeModal">
        <template #header>
            <h2 class="text-xl font-semibold">{{ isEditing ? 'Edit Project' : 'Create New Project' }}</h2>
        </template>
        <template #body>
            <ProjectForm 
                :project="currentProject" 
                :error="formError"
                @submit="handleFormSubmit"
                @cancel="closeModal"
            />
        </template>
         <template #footer>
            <div></div> <!-- Hides default footer buttons -->
        </template>
    </Modal>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import apiService from '../services/apiService';
import Modal from '../components/Modal.vue';
import ProjectForm from '../components/ProjectForm.vue';
import Toast from '../components/Toast.vue';

const projects = ref([]);
const loading = ref(true);
const error = ref(null);
const formError = ref(null);

const showModal = ref(false);
const currentProject = ref({});
const isEditing = computed(() => !!currentProject.value.id);

const toastMessage = ref('');
const toastType = ref('success');

const defaultProject = {
    title: '',
    description: '',
    category: 'Web Development',
    progress: 0,
    live_link: '',
    code_link: '',
    visibility: 'private',
};

const fetchProjects = async () => {
  try {
    const response = await apiService.get('/projects');
    projects.value = response.data.data;
  } catch (err) {
    error.value = 'Failed to load your projects.';
    console.error(err);
  } finally {
    loading.value = false;
  }
};

const openCreateModal = () => {
    currentProject.value = { ...defaultProject };
    formError.value = null;
    showModal.value = true;
};

const openEditModal = (project) => {
    currentProject.value = { ...project };
    formError.value = null;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    currentProject.value = {};
};

const handleFormSubmit = async (projectData) => {
    formError.value = null;
    const data = { ...projectData };
    if (data.code_link) {
        data.github_link = data.code_link;
        delete data.code_link;
    }
    try {
        if (isEditing.value) {
            const response = await apiService.put(`/projects/${data.id}`, data);
            const index = projects.value.findIndex(p => p.id === data.id);
            if (index !== -1) {
                projects.value[index] = response.data.data;
            }
            toastMessage.value = 'Project updated!';
        } else {
            const response = await apiService.post('/projects', data);
            projects.value.unshift(response.data.data);
            toastMessage.value = 'Project created!';
        }
        toastType.value = 'success';
        closeModal();
        setTimeout(() => (toastMessage.value = ''), 3000);
    } catch (err) {
        toastType.value = 'error';
        if (err.response && err.response.status === 422) {
            formError.value = err.response.data.errors;
            toastMessage.value = 'Validation error. Please check your input.';
        } else {
            formError.value = { general: 'An unexpected error occurred. Please try again.' };
            toastMessage.value = 'Failed to save project.';
        }
        setTimeout(() => (toastMessage.value = ''), 3000);
        console.error(err);
    }
};

const confirmDelete = (id) => {
    if (window.confirm('Are you sure you want to delete this project?')) {
        deleteProject(id);
    }
};

const deleteProject = async (id) => {
    try {
        await apiService.delete(`/projects/${id}`);
        projects.value = projects.value.filter(p => p.id !== id);
        toastMessage.value = 'Project deleted!';
        toastType.value = 'success';
        setTimeout(() => (toastMessage.value = ''), 3000);
    } catch (err) {
        error.value = 'Failed to delete project.';
        toastMessage.value = 'Failed to delete project.';
        toastType.value = 'error';
        setTimeout(() => (toastMessage.value = ''), 3000);
        console.error(err);
    }
};

onMounted(fetchProjects);
</script> 