import axios from 'axios';


export const ubicacionesModule = {
    namespaced: true,
    state: {
        ubicaciones: [],
        isLoading: false,
        error: null,
    },
    mutations: {
        SET_UBICACIONES(state, ubicaciones) {
            state.ubicaciones = ubicaciones;
        },
        SET_LOADING(state, isLoading) {
            state.isLoading = isLoading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
    },
    actions: {
        async fetchUbicaciones({ commit }) {
            commit('SET_LOADING', true);
            commit('SET_ERROR', null);
            try {
                const { data } = await axios.get(`/ubicaciones`);
                commit('SET_UBICACIONES', data);
            } catch (error) {
                commit('SET_ERROR', error.message);
            } finally {
                commit('SET_LOADING', false);
            }
        },
    },
    getters: {
        ubicaciones: state => state.ubicaciones,
        isLoading: state => state.isLoading,
        error: state => state.error,
    },
};
