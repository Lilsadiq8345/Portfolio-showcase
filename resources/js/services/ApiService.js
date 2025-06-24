import axios from 'axios';

const apiService = axios.create({
    baseURL: '/api', // Use relative URL 
    withCredentials: true, // Ensure cookies are sent for Sanctum
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
    }
});

apiService.interceptors.request.use(config => {
    const token = localStorage.getItem('auth_token'); // Correct key from authService
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

export default apiService; 