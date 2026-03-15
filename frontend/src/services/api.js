import axios from 'axios'
import useAuthStore from '../store/useAuthStore'

const api = axios.create({
    baseURL: 'http://localhost/api',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
})

api.interceptors.request.use((config) => {
    const token = useAuthStore.getState().token

    if (token) {
        config.headers.Authorization = `Bearer ${token}`
    }

    return config
})

api.interceptors.response.use((response) => response, async (error) => {
    const originalRequest = error.config

    if (error.response?.status === 401 && !originalRequest._retry) {
        originalRequest._retry = true

        const refreshToken = useAuthStore.getState().refreshToken

        if (!refreshToken) {
            useAuthStore.getState().clearAuth()
            window.location.href = '/login'
            return Promise.reject(error)
        }

        try {
            const response = await axios.post('http://localhost/api/auth/refresh', {
                refresh_token: refreshToken,
            })

            const { token, refresh_token } = response.data

            const state = useAuthStore.getState()
            useAuthStore.getState().setAuth(state.user, token, state.role, refresh_token)

            return axios({
                method: originalRequest.method,
                url: originalRequest.baseURL + originalRequest.url,
                data: originalRequest.data,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            })
        } catch {
            useAuthStore.getState().clearAuth()
            window.location.href = '/login'
            return Promise.reject(error)
        }
    }

    return Promise.reject(error)
})

export default api