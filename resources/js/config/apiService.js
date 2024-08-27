import axios from 'axios';

const apiClient = axios.create({
    baseURL: 'http://tu-dominio-api.com/api',
    withCredentials: false,
    headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
    },
});

export default {
    async getBuses(params = {}) {
        try {
            const response = await apiClient.get('/buses', { params });
            return response.data; // Retorna solo los datos de la respuesta
        } catch (error) {
            // Manejo del error
            throw error;
        }
    },

}
