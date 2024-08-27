import axios from 'axios';

export const bancosModule = {
    namespaced: true,
    state: {
        bancos: [],
        isLoading: false,
        error: null,
    },
    mutations: {
        SET_BANCOS(state, bancos) {
            state.bancos = bancos;
        },
        SET_LOADING(state, isLoading) {
            state.isLoading = isLoading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
    },
    actions: {
        async fetchBancos({ commit }) {
            commit('SET_LOADING', true);
            commit('SET_ERROR', null);
            try {
                const { data } = await axios.get(`/bancos`);
                commit('SET_BANCOS', data);
            } catch (error) {
                commit('SET_ERROR', error.message);
            } finally {
                commit('SET_LOADING', false);
            }
        },
    },
    getters: {
        bancos: state => state.bancos,
        isLoading: state => state.isLoading,
        error: state => state.error,
    },
};
