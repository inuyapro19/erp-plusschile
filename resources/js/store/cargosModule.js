import axios from 'axios';


export const cargosModule = {
    namespaced: true,
    state: {
        cargos: [],
        isLoading: false,
        error: null,
    },
    mutations: {
        SET_CARGOS(state, cargos) {
            state.cargos = cargos;
        },
        SET_LOADING(state, isLoading) {
            state.isLoading = isLoading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
    },
    actions: {
        async fetchCargos({ commit }) {
            commit('SET_LOADING', true);
            commit('SET_ERROR', null);
            try {
                const { data } = await axios.get(`/cargos`);
                commit('SET_CARGOS', data);
            } catch (error) {
                commit('SET_ERROR', error.message);
            } finally {
                commit('SET_LOADING', false);
            }
        },
    },
    getters: {
        cargos: state => state.cargos,
        isLoading: state => state.isLoading,
        error: state => state.error,
    },
};
