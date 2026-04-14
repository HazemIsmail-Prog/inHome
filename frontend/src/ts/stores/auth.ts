import router from "@/ts/router"
import axiosInstance from "@/ts/lib/axios"
import { defineStore } from "pinia"
import { computed, ref } from "vue"
import type { LoginForm, User } from "@/ts/types"

export const useAuthStore = defineStore('auth', () => {
    
    const user = ref<User | null>(null)
    const loading = ref(false)
    const authError = ref<any | null>(null)
    const isAuthenticated = computed(() => user.value && localStorage.getItem('token'))

    const getUser = async () => {
            authError.value = null
            const response = await axiosInstance.get('/api/user')
            user.value = response.data
    }

    const login = async (payload: LoginForm) => {
        try {
            loading.value = true
            authError.value = null
            const response = await axiosInstance.post('/api/login', payload)
            localStorage.setItem('token', response.data)
            await getUser()
            router.push({ name: 'dashboard' })
        } finally {
            loading.value = false
        }
    }

    const logout = async () => {
        try {
            loading.value = true
            await axiosInstance.post('/api/logout')
            router.push({ name: 'login' })
        } finally {
            loading.value = false
            user.value = null
            localStorage.removeItem('token')       
        }
    }

    return { login, logout, loading, authError, user, getUser, isAuthenticated }
},{
    persist:{
        storage:localStorage,
        pick:['user']
    }
})