import axios from 'axios';


export const nacionalidadesModule = {
    namespaced: true,
    state: {
        nacionalidades: [],
        isLoading: false,
        error: null,
    },
    mutations: {
        SET_NACIONALIDADES(state, nacionalidades) {
            state.nacionalidades = nacionalidades;
        },
        SET_LOADING(state, isLoading) {
            state.isLoading = isLoading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
    },
    actions: {
        async fetchNacionalidades({ commit }) {
            commit('SET_LOADING', true);
            commit('SET_ERROR', null);
            try {
                const { data } = await axios.get(`/nacionalidades`);
                commit('SET_NACIONALIDADES', data);
            } catch (error) {
                commit('SET_ERROR', error.message);
            } finally {
                commit('SET_LOADING', false);
            }
        },
    },
    getters: {
        nacionalidades: state => state.nacionalidades,
        isLoading: state => state.isLoading,
        error: state => state.error,
    },
};
