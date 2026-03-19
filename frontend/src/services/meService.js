import api from './api'

export const getMyContexts = () => api.get('/me/contexts')