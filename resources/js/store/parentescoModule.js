import axios from 'axios';

export const parentescoModule = {
    namespaced: true,
    state: {
        parentescos: [],
        isLoading: false,
        error: null,
    },
    mutations: {
        SET_PARENTESCOS(state, parentescos) {
            state.parentescos = parentescos;
        },
        SET_LOADING(state, isLoading) {
            state.isLoading = isLoading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
    },
    actions: {
        async fetchParentescos({ commit }) {
            commit('SET_LOADING', true);
            commit('SET_ERROR', null);
            try {
                const { data } = await axios.get(`/codigo_parentesco`);
                commit('SET_PARENTESCOS', data);
            } catch (error) {
                commit('SET_ERROR', error.message);
            } finally {
                commit('SET_LOADING', false);
            }
        },
    },
    getters: {
        parentescos: state => state.parentescos,
        isLoading: state => state.isLoading,
        error: state => state.error,
    },
}
