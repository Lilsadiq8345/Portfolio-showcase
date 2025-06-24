<template>
  <div class="container mx-auto p-4 md:p-8">
    <Toast v-if="toastMessage" :message="toastMessage" :type="toastType" />
    <div v-if="loading" class="text-center">
      <p>Loading profile...</p>
    </div>
    <div v-else-if="error" class="text-center text-red-500">
      <p>{{ error }}</p>
    </div>
    <div v-else-if="user" class="profile-container">
      <header class="text-center mb-8">
        <h1 class="text-4xl font-bold">{{ user.name }}'s Portfolio</h1>
        <p class="text-lg text-gray-600">{{ user.email }}</p>
        <p v-if="user.bio" class="mt-2 text-gray-700 italic">{{ user.bio }}</p>
        <div v-if="user.skills && user.skills.length" class="mt-2 flex flex-wrap justify-center gap-2">
          <span v-for="skill in user.skills" :key="skill.id" class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">{{ skill.name }}</span>
        </div>
      </header>

      <section v-if="isOwnProfile">
        <h2 class="text-xl font-semibold mb-2">Edit Bio & Skills</h2>
        <form @submit.prevent="updateProfile" class="mb-8 bg-white p-4 rounded shadow">
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Bio</label>
            <textarea v-model="bio" rows="3" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Skills</label>
            <select v-model="selectedSkills" multiple class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
              <option v-for="skill in allSkills" :key="skill.id" :value="skill.id">{{ skill.name }} ({{ skill.type }})</option>
            </select>
          </div>
          <button type="submit" :disabled="saving" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50">Save</button>
          <span v-if="saveSuccess" class="ml-4 text-green-600">Profile updated!</span>
          <span v-if="saveError" class="ml-4 text-red-600">{{ saveError }}</span>
        </form>
      </section>

      <section>
        <h2 class="text-2xl font-semibold mb-4 border-b pb-2">Projects</h2>
        <div v-if="user.projects && user.projects.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <ProjectCard v-for="project in user.projects" :key="project.id" :project="project" />
        </div>
        <div v-else>
          <p>This user hasn't added any projects yet.</p>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import apiService from '../services/apiService';
import ProjectCard from '../components/ProjectCard.vue';
import Toast from '../components/Toast.vue';

const props = defineProps({
  username: String,
});

const user = ref(null);
const loading = ref(true);
const error = ref(null);
const allSkills = ref([]);
const bio = ref('');
const selectedSkills = ref([]);
const saving = ref(false);
const saveSuccess = ref(false);
const saveError = ref('');
const toastMessage = ref('');
const toastType = ref('success');

const isOwnProfile = computed(() => {
  // You may want to use a global auth state instead
  return user.value && user.value.is_current_user;
});

const fetchSkills = async () => {
  try {
    const res = await apiService.get('/api/skills');
    allSkills.value = res.data;
  } catch (err) {
    allSkills.value = [];
  }
};

const updateProfile = async () => {
  saving.value = true;
  saveSuccess.value = false;
  saveError.value = '';
  try {
    await apiService.put('/api/profile', {
      bio: bio.value,
      skills: selectedSkills.value,
    });
    saveSuccess.value = true;
    toastMessage.value = 'Profile updated!';
    toastType.value = 'success';
  } catch (err) {
    saveError.value = 'Failed to update profile.';
    toastMessage.value = 'Failed to update profile.';
    toastType.value = 'error';
  } finally {
    saving.value = false;
    setTimeout(() => (saveSuccess.value = false), 2000);
    setTimeout(() => (toastMessage.value = ''), 3000);
  }
};

onMounted(async () => {
  try {
    const response = await apiService.get(`/profiles/${props.username}`);
    user.value = response.data.data;
    bio.value = user.value.bio || '';
    selectedSkills.value = user.value.skills ? user.value.skills.map(s => s.id) : [];
    // If this is the current user, fetch all skills for editing
    if (isOwnProfile.value) await fetchSkills();
  } catch (err) {
    error.value = 'Failed to load profile. The user may not exist or an error occurred.';
    console.error(err);
  } finally {
    loading.value = false;
  }
});
</script> 