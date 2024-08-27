import axios from 'axios';

export const areasModule = {
    namespaced: true,
    state: {
        areas: [],
        isLoading: false,
        error: null,
    },
    mutations: {
        SET_AREAS(state, areas) {
            state.areas = areas;
        },
        SET_LOADING(state, isLoading) {
            state.isLoading = isLoading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
    },
    actions: {
        async fetchAreas({ commit }) {
            commit('SET_LOADING', true);
            commit('SET_ERROR', null);
            try {
                const { data } = await axios.get(`/areas`);
                commit('SET_AREAS', data);
            } catch (error) {
                commit('SET_ERROR', error.message);
            } finally {
                commit('SET_LOADING', false);
            }
        },
    },
    getters: {
        areas: state => state.areas,
        isLoading: state => state.isLoading,
        error: state => state.error,
    },
};
