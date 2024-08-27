import axios from 'axios';
export const movimientosTrabajadorModule = {
    namespaced: true,
    state: {
        movimientos: [],
        isLoading: false,
        error: null,
    },
    mutations: {
        SET_MOVIMIENTOS(state, movimientos) {
            state.movimientos = movimientos;
        },
        SET_LOADING(state, isLoading) {
            state.isLoading = isLoading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
    },
    actions: {
        async fetchMovimientosTrabajador({ commit }) {
            commit('SET_LOADING', true);
            commit('SET_ERROR', null);
            try {
                const { data } = await axios.get(`/motivos`);
                commit('SET_MOVIMIENTOS', data);
            } catch (error) {
                commit('SET_ERROR', error.message);
            } finally {
                commit('SET_LOADING', false);
            }
        },
    },
    getters: {
        movimientos: state => state.movimientos,
        isLoading: state => state.isLoading,
        error: state => state.error,
    },
};
