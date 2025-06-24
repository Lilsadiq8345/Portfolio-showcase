<template>
  <form @submit.prevent="handleSubmit">
    <div class="mb-4">
      <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
      <input type="text" v-model="form.title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
      <p v-if="error && error.title" class="text-red-500 text-xs mt-1">{{ error.title[0] }}</p>
    </div>
    <div class="mb-4">
      <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
      <textarea v-model="form.description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required></textarea>
      <p v-if="error && error.description" class="text-red-500 text-xs mt-1">{{ error.description[0] }}</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
      <div>
        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
        <select v-model="form.category" id="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            <option>Frontend</option>
            <option>Backend</option>
            <option>Database</option>
        </select>
        <p v-if="error && error.category" class="text-red-500 text-xs mt-1">{{ error.category[0] }}</p>
      </div>
      <div>
        <label for="progress" class="block text-sm font-medium text-gray-700">Progress (%)</label>
        <input type="number" v-model.number="form.progress" id="progress" min="0" max="100" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
        <p v-if="error && error.progress" class="text-red-500 text-xs mt-1">{{ error.progress[0] }}</p>
      </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
      <div>
        <label for="live_link" class="block text-sm font-medium text-gray-700">Live Demo URL</label>
        <input type="url" v-model="form.live_link" id="live_link" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        <p v-if="error && error.live_link" class="text-red-500 text-xs mt-1">{{ error.live_link[0] }}</p>
      </div>
      <div>
        <label for="code_link" class="block text-sm font-medium text-gray-700">Source Code URL</label>
        <input type="url" v-model="form.code_link" id="code_link" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        <p v-if="error && error.github_link" class="text-red-500 text-xs mt-1">{{ error.github_link[0] }}</p>
      </div>
    </div>
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700">Skills/Tags</label>
      <select v-model="form.skills" multiple class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        <option v-for="skill in allSkills" :key="skill.id" :value="skill.id">{{ skill.name }} ({{ skill.type }})</option>
      </select>
    </div>
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700">Visibility</label>
      <div class="mt-2 flex items-center">
        <input type="radio" v-model="form.visibility" value="public" id="public-form" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
        <label for="public-form" class="ml-3 block text-sm font-medium text-gray-700">Public</label>
      </div>
      <div class="flex items-center">
        <input type="radio" v-model="form.visibility" value="private" id="private-form" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
        <label for="private-form" class="ml-3 block text-sm font-medium text-gray-700">Private</label>
      </div>
      <p v-if="error && error.visibility" class="text-red-500 text-xs mt-1">{{ error.visibility[0] }}</p>
    </div>
    <p v-if="error && error.general" class="text-red-500 text-sm mt-2">{{ error.general }}</p>
    <div class="flex justify-end">
        <button type="button" @click="$emit('cancel')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 mr-2">Cancel</button>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Save</button>
    </div>
  </form>
</template>

<script setup>
import { reactive, watch, ref, onMounted } from 'vue';
import apiService from '../services/apiService';

const props = defineProps({
  project: {
    type: Object,
    default: () => ({
      title: '',
      description: '',
      category: 'Frontend',
      progress: 0,
      live_link: '',
      code_link: '',
      visibility: 'private',
    }),
  },
  error: Object,
});

const emit = defineEmits(['submit', 'cancel']);

const allSkills = ref([]);

const form = reactive({ ...props.project, skills: props.project.skills ? props.project.skills.map(s => s.id) : [] });

onMounted(async () => {
  try {
    const res = await apiService.get('/api/skills');
    allSkills.value = res.data;
  } catch (err) {
    allSkills.value = [];
  }
});

watch(() => props.project, (newVal) => {
  Object.assign(form, newVal);
});

const handleSubmit = () => {
  emit('submit', form);
};
</script> 