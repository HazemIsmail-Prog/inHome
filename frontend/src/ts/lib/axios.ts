import router from '@/ts/router'
import { useAuthStore } from '@/ts/stores/auth';
import axios from 'axios'
const axiosInstance = axios.create({
    baseURL: import.meta.env.VITE_API_URL,
    headers: {
        'Accept': 'application/json',
    },
})

axiosInstance.interceptors.request.use((config) => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

axiosInstance.interceptors.response.use(
    (response) => {
        return response
    },
    (error) => {
        const auth = useAuthStore()
        if (error.response.status === 401) {
            localStorage.removeItem('token')
            auth.user = null
            auth.authError = error.response.data
            router.push({ name: 'login' })
        }
        if (error.response.status === 403) {
            router.replace({ name: 'unauthorized' })
        }
        return Promise.reject(error)
    }
)

export default axiosInstance