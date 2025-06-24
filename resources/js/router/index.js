import { createRouter, createWebHistory } from 'vue-router';

// Import pages
import Login from '../pages/Login.vue';
import Register from '../pages/Register.vue';
import Dashboard from '../pages/Dashboard.vue';
import Profile from '../pages/Profile.vue';
import NotFound from '../pages/NotFound.vue';
import authService from '../services/authService';

// Admin Pages
import AdminLogin from '../pages/admin/Login.vue';
import AdminDashboard from '../pages/admin/Dashboard.vue';
import AddUser from '../pages/admin/AddUser.vue';
import AddProject from '../pages/admin/AddProject.vue';
import AdminUsers from '../pages/admin/AdminUsers.vue';
import AdminProjects from '../pages/admin/AdminProjects.vue';
import EditUser from '../pages/admin/EditUser.vue';
import EditProject from '../pages/admin/EditProject.vue';

const routes = [
    { path: '/', name: 'Home', redirect: '/dashboard' },
    { path: '/login', name: 'Login', component: Login },
    { path: '/register', name: 'Register', component: Register },
    { path: '/dashboard', name: 'Dashboard', component: Dashboard, meta: { requiresAuth: true } },
    { path: '/profile/:username', name: 'Profile', component: Profile, props: true },

    // Admin routes
    { path: '/admin/login', name: 'AdminLogin', component: AdminLogin },
    { path: '/admin/dashboard', name: 'AdminDashboard', component: AdminDashboard, meta: { requiresAuth: true, requiresAdmin: true } },
    { path: '/admin/users/add', name: 'AddUser', component: AddUser, meta: { requiresAuth: true, requiresAdmin: true } },
    { path: '/admin/projects/add', name: 'AddProject', component: AddProject, meta: { requiresAuth: true, requiresAdmin: true } },
    { path: '/admin/users', name: 'AdminUsers', component: AdminUsers, meta: { requiresAuth: true, requiresAdmin: true } },
    { path: '/admin/projects', name: 'AdminProjects', component: AdminProjects, meta: { requiresAuth: true, requiresAdmin: true } },
    { path: '/admin/users/edit/:id', name: 'EditUser', component: EditUser, meta: { requiresAuth: true, requiresAdmin: true }, props: true },
    { path: '/admin/projects/edit/:id', name: 'EditProject', component: EditProject, meta: { requiresAuth: true, requiresAdmin: true }, props: true },

    { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Navigation Guard
router.beforeEach((to, from, next) => {
    authService.checkAuth();
    const isAuthenticated = authService.state.isAuthenticated;
    const user = authService.state.user;

    // Admin Route Guard
    if (to.meta.requiresAdmin) {
        if (isAuthenticated && user?.is_admin) {
            next();
        } else {
            // Redirect to admin login if not an authenticated admin
            next({ name: 'AdminLogin' });
        }
        return;
    }

    // Regular Authenticated Route Guard
    if (to.meta.requiresAuth && !isAuthenticated) {
        next({ name: 'Login' });
    } else {
        next();
    }
});

export default router; 