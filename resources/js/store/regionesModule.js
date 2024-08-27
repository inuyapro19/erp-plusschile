import axios from 'axios';


export const regionesModule = {
    namespaced: true,
    state: {
        regiones: [],
        isLoading: false,
        error: null,
    },
    mutations: {
        setRegionesLoading(state, payload) {
            state.isLoading = payload;
        },
        setRegiones(state, payload) {
            state.regiones = payload;
        },
        setRegionesError(state, payload) {
            state.error = payload;
        },
    },
    actions: {
        async fetchRegiones({ commit }) {
            commit('setRegionesLoading', true);
            commit('setRegionesError', null);
            try {
                const { data } = await axios.get( '/regiones');
                commit('setRegiones', data);
                commit('setRegionesLoading', false);
            } catch (error) {
                commit('setRegionesError', error.message);
                commit('setRegionesLoading', false);
            }
        },
    },
    getters: {
        regiones: state => state.regiones,
        isRegionesLoading: state => state.isLoading,
        regionesError: state => state.error,
    },
};
