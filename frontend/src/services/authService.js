import api from './api'

export const registerUser = (data) => api.post('/auth/register', data)

export const verifyEmail = (data) => api.post('/auth/verify-email', data)

export const completeRegistration = (data) => api.post('/auth/complete-registration', data)

export const login = (data) => api.post('/auth/login', data)