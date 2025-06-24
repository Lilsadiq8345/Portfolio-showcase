<template>
  <transition name="fade">
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" @click.self="close">
      <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4">
        <header class="p-4 border-b flex justify-between items-center">
          <h2 class="text-xl font-semibold">
            <slot name="header">Default Header</slot>
          </h2>
          <button @click="close" class="text-gray-500 hover:text-gray-800">&times;</button>
        </header>
        <section class="p-4">
          <slot name="body">Default Body</slot>
        </section>
        <footer class="p-4 border-t">
          <slot name="footer">
             <button @click="close" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Close</button>
          </slot>
        </footer>
      </div>
    </div>
  </transition>
</template>

<script setup>
defineProps({
  show: Boolean,
});

const emit = defineEmits(['close']);

const close = () => {
  emit('close');
};
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style> 