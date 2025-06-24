<template>
  <div id="app" class="bg-gray-50 min-h-screen">
    <nav class="bg-white shadow-md">
      <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
          <router-link to="/" class="text-xl font-bold text-gray-800">PortfolioShowcase</router-link>

          <div class="flex items-center space-x-4">
             <!-- Public links -->
            <router-link to="/" class="text-gray-600 hover:text-gray-800">Home</router-link>

            <!-- Auth links -->
            <template v-if="isAuthenticated && user">
              <router-link :to="{ name: 'Dashboard' }" class="text-gray-600 hover:text-gray-800">Dashboard</router-link>
              <router-link :to="{ name: 'Profile', params: { username: user.name } }" class="text-gray-600 hover:text-gray-800">My Profile</router-link>
              <button @click="handleLogout" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Logout</button>
            </template>

            <!-- Guest links -->
            <template v-else>
              <router-link to="/login" class="text-gray-600 hover:text-gray-800">Login</router-link>
              <router-link to="/register" class="text-gray-600 hover:text-gray-800">Register</router-link>
            </template>
          </div>
        </div>
      </div>
    </nav>

    <main>
      <router-view />
    </main>
  </div>
</template>

<script setup>
import { computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import authService from './services/authService';
import apiService from './services/apiService';

const router = useRouter();

const isAuthenticated = computed(() => authService.state.isAuthenticated);
const user = computed(() => authService.state.user);

const handleLogout = async () => {
  try {
    await apiService.post('/logout');
  } catch (error) {
    console.error('Failed to logout from server, logging out client-side anyway.', error);
  } finally {
    authService.logout();
    router.push({ name: 'Login' });
  }
};

onMounted(() => {
  authService.checkAuth();
});
</script>

<style>
/* You can add global styles here if needed */
body {
  font-family: 'Inter', sans-serif;
}
</style> 