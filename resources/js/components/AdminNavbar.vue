<template>
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-gradient-to-b from-blue-900 to-blue-700 text-white flex flex-col py-8 px-4 shadow-lg">
      <div class="mb-10 flex items-center justify-center">
        <span class="text-2xl font-bold tracking-wide">Sparktro</span>
        <span class="ml-2 bg-yellow-400 text-blue-900 text-xs font-semibold px-2 py-1 rounded">ADMIN</span>
      </div>
      <nav class="flex-1">
        <ul class="space-y-4">
          <li><router-link to="/admin/dashboard" class="flex items-center px-3 py-2 rounded hover:bg-blue-800 transition"><span class="material-icons mr-2">dashboard</span>Dashboard</router-link></li>
          <li><router-link to="/admin/users" class="flex items-center px-3 py-2 rounded hover:bg-blue-800 transition"><span class="material-icons mr-2">group</span>Users</router-link></li>
          <li><router-link to="/admin/users/add" class="flex items-center px-3 py-2 rounded hover:bg-blue-800 transition"><span class="material-icons mr-2">person_add</span>Add User</router-link></li>
          <li><router-link to="/admin/projects" class="flex items-center px-3 py-2 rounded hover:bg-blue-800 transition"><span class="material-icons mr-2">folder</span>Projects</router-link></li>
          <li><router-link to="/admin/projects/add" class="flex items-center px-3 py-2 rounded hover:bg-blue-800 transition"><span class="material-icons mr-2">add_box</span>Add Project</router-link></li>
          <li><router-link to="/admin/settings" class="flex items-center px-3 py-2 rounded hover:bg-blue-800 transition"><span class="material-icons mr-2">settings</span>Settings</router-link></li>
        </ul>
      </nav>
      <div class="mt-10">
        <button @click="logout" class="w-full bg-red-500 hover:bg-red-600 px-3 py-2 rounded text-white font-semibold flex items-center justify-center"><span class="material-icons mr-2">logout</span>Logout</button>
      </div>
    </aside>
    <!-- Main content slot -->
    <main class="flex-1 bg-gray-50 p-8">
      <slot />
    </main>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

function logout() {
  localStorage.removeItem('token');
  router.push('/admin/login');
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/icon?family=Material+Icons');
</style> 