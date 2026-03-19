import api from './api'

export const createOrganisation = (data) => api.post('/organisations', data)