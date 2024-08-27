import axios from 'axios';


export const previsionSaludModule = {
    namespaced: true,
    state: {
        salud: [],
        isLoading: false,
        error: null,
    },
    mutations: {
        SET_SALUD(state, salud) {
            state.salud = salud;
        },
        SET_LOADING(state, isLoading) {
            state.isLoading = isLoading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
    },
    actions: {
        async fetchPrevisionSalud({ commit }) {
            commit('SET_LOADING', true);
            commit('SET_ERROR', null);
            try {
                const { data } = await axios.get(`/salud`);
                commit('SET_SALUD', data);
            } catch (error) {
                commit('SET_ERROR', error.message);
            } finally {
                commit('SET_LOADING', false);
            }
        },
    },
    getters: {
        salud: state => state.salud,
        isLoading: state => state.isLoading,
        error: state => state.error,
    },
};
