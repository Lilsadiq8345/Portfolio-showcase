<template>
  <div class="bg-white rounded-lg shadow-md p-4 flex flex-col h-full">
    <img v-if="project.thumbnail" :src="project.thumbnail" alt="Project Image" class="w-full h-40 object-cover rounded mb-4" />
    <div class="flex-1 flex flex-col">
      <h3 class="text-xl font-bold mb-1">{{ project.title }}</h3>
      <p class="text-gray-700 mb-2 flex-1">{{ project.description }}</p>
      <div class="mb-2 flex flex-wrap gap-2">
        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">{{ project.category }}</span>
        <span v-for="skill in project.skills" :key="skill.id" class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">{{ skill.name }}</span>
      </div>
      <div class="mb-2">
        <div class="flex items-center mb-1">
          <span class="text-xs text-gray-500 mr-2">Progress</span>
          <span class="text-xs font-semibold">{{ project.progress }}%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2.5">
          <div class="bg-blue-600 h-2.5 rounded-full" :style="{ width: project.progress + '%' }"></div>
        </div>
      </div>
      <div class="flex justify-between items-center mt-2">
        <div class="flex gap-2">
          <a v-if="project.live_link" :href="project.live_link" target="_blank" class="text-blue-500 hover:underline text-xs">Live Demo</a>
          <a v-if="project.code_link" :href="project.code_link" target="_blank" class="text-gray-500 hover:underline text-xs">Source Code</a>
        </div>
        <span v-if="project.visibility === 'public'" class="bg-green-200 text-green-800 text-xs px-2 py-0.5 rounded">Public</span>
        <span v-else class="bg-gray-300 text-gray-700 text-xs px-2 py-0.5 rounded">Private</span>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  project: { type: Object, required: true }
});
</script> 