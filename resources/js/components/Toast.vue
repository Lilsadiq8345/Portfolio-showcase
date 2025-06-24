<template>
  <transition name="fade">
    <div v-if="visible" :class="toastClass" class="fixed top-6 right-6 z-50 px-4 py-3 rounded shadow-lg flex items-center min-w-[200px]">
      <span class="mr-2">
        <svg v-if="type === 'success'" class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
        <svg v-else class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
      </span>
      <span>{{ message }}</span>
    </div>
  </transition>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';
const props = defineProps({
  message: { type: String, required: true },
  type: { type: String, default: 'success' },
});
const visible = ref(true);
const toastClass = computed(() =>
  props.type === 'success'
    ? 'bg-green-100 text-green-800 border border-green-300'
    : 'bg-red-100 text-red-800 border border-red-300'
);
onMounted(() => {
  setTimeout(() => (visible.value = false), 3000);
});
watch(() => props.message, () => {
  visible.value = true;
  setTimeout(() => (visible.value = false), 3000);
});
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style> 