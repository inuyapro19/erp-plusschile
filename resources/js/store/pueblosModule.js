import axios from 'axios';

export const pueblosModule = {
    namespaced: true,
    state: {
        pueblosOriginarios: [],
        isLoading: false,
        error: null,
    },
    mutations: {
        SET_PUEBLOS(state, pueblosOriginarios) {
            state.pueblosOriginarios = pueblosOriginarios;
        },
        SET_LOADING(state, isLoading) {
            state.isLoading = isLoading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
    },
    actions: {
        async fetchPueblosOriginarios({ commit }) {
            commit('SET_LOADING', true);
            commit('SET_ERROR', null);
            try {
                const { data } = await axios.get(`/pueblos_originarios`);
                commit('SET_PUEBLOS', data);
            } catch (error) {
                commit('SET_ERROR', error.message);
            } finally {
                commit('SET_LOADING', false);
            }
        },
    },
    getters: {
        pueblosOriginarios: state => state.pueblosOriginarios,
        isLoading: state => state.isLoading,
        error: state => state.error,
    },
};
