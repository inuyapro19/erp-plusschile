import axios from 'axios';


export const comunasModule = {
    namespaced: true,
    state: {
        comunas: [],
        isLoading: false,
        error: null,
    },
    mutations: {
        setComunasLoading(state, payload) {
            state.isLoading = payload;
        },
        setComunas(state, payload) {
            state.comunas = payload;
        },
        setComunasError(state, payload) {
            state.error = payload;
        },
    },
    actions: {
        async fetchComunas({ commit }) {
            commit('setComunasLoading', true);
            commit('setComunasError', null);
            try {
                const { data } = await axios.get('/comunas');
                commit('setComunas', data);
                commit('setComunasLoading', false);
            } catch (error) {
                commit('setComunasError', error.message);
                commit('setComunasLoading', false);
            }
        },
        async fetchComunasById({ commit }, region_id) {
            commit('setComunasLoading', true);
            commit('setComunasError', null);
            try {
                const { data } = await axios.get('/comunas/' + region_id);
                commit('setComunas', data);
                commit('setComunasLoading', false);
            } catch (error) {
                commit('setComunasError', error.message);
                commit('setComunasLoading', false);
            }
        },
    },
    getters: {
        comunas: state => state.comunas,
        isComunasLoading: state => state.isLoading,
        comunasError: state => state.error,
    },
};
