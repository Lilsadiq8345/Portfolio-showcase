<template>
  <div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white flex flex-col">
      <div class="p-6 text-2xl font-bold border-b border-gray-800 text-center">
        <a href="/">Sparktro</a>
      </div>
      <nav class="flex-1 px-4 py-6 space-y-2">
        <a href="#dashboard" class="flex items-center px-4 py-2 text-white bg-blue-600 rounded-md">
          <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
          <span>Dashboard</span>
        </a>
        <a href="#users" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
          <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197"></path></svg>
          <span>Users</span>
        </a>
        <a href="#projects" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
          <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0l3-3m0 0l3 3m-3-3v12"></path></svg>
          <span>Projects</span>
        </a>
      </nav>
      <div class="p-4 border-t border-gray-800">
        <button @click="handleLogout" class="w-full bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700 transition">Logout</button>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 md:p-10 overflow-y-auto">
      <div v-if="loading" class="text-center">
        <p>Loading admin data...</p>
      </div>
      <div v-else-if="error" class="text-center text-red-500">
        <p>{{ error }}</p>
      </div>
      <div v-else class="space-y-12">
        <!-- Users Section -->
        <section id="users">
          <h2 class="text-2xl font-semibold mb-4 text-gray-800">All Users</h2>
          <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="user in data.users" :key="user.id">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ user.name }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ user.email }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span :class="user.is_admin ? 'bg-yellow-200 text-yellow-800' : 'bg-green-200 text-green-800'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                      {{ user.is_admin ? 'Admin' : 'User' }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ new Date(user.created_at).toLocaleDateString() }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>

        <!-- Projects Section -->
        <section id="projects">
          <h2 class="text-2xl font-semibold mb-4 text-gray-800">All Projects</h2>
          <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project Title</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Owner</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visibility</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="project in data.projects" :key="project.id">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ project.title }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ project.user.name }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ project.category }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">
                     <span :class="project.visibility === 'public' ? 'bg-blue-200 text-blue-800' : 'bg-gray-200 text-gray-800'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                      {{ project.visibility }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import apiService from '../../services/apiService';
import authService from '../../services/authService';

const data = ref({ users: [], projects: [] });
const loading = ref(true);
const error = ref(null);
const router = useRouter();

const fetchData = async () => {
  try {
    const response = await apiService.get('/admin/dashboard');
    data.value = response.data;
  } catch (err) {
    error.value = 'Failed to load admin data. You may not have permission.';
    console.error(err);
  } finally {
    loading.value = false;
  }
};

const handleLogout = async () => {
    authService.logout();
    router.push({ name: 'AdminLogin' });
};

onMounted(fetchData);
</script> 