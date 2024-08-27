import axios from 'axios';


export const empleadoresModule = {
    namespaced: true,
    state: {
        empleadores: [],
        isLoading: false,
        error: null,
    },
    mutations: {
        SET_EMPLEADORES(state, empleadores) {
            state.empleadores = empleadores;
        },
        SET_LOADING(state, isLoading) {
            state.isLoading = isLoading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
    },
    actions: {
        async fetchEmpleadores({ commit }) {
            commit('SET_LOADING', true);
            commit('SET_ERROR', null);
            try {
                const { data } = await axios.get(`/empleador`);
                commit('SET_EMPLEADORES', data);
            } catch (error) {
                commit('SET_ERROR', error.message);
            } finally {
                commit('SET_LOADING', false);
            }
        },
    },
    getters: {
        empleadores: state => state.empleadores,
        isLoading: state => state.isLoading,
        error: state => state.error,
    },
};
