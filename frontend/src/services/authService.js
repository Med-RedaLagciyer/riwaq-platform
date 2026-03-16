import api from './api'

export const registerUser = (data) => api.post('/auth/register', data)

export const verifyEmail = (data) => api.post('/auth/verify-email', data)

export const completeRegistration = (data) => api.post('/auth/complete-registration', data)

export const login = (data) => api.post('/auth/login', data)

export const forgotPassword = (data) => api.post('/auth/forgot-password', data)

export const verifyResetCode = (data) => api.post('/auth/verify-reset-code', data)

export const resetPassword = (data) => api.post('/auth/reset-password', data)