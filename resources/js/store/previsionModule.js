import axios from 'axios';


export const previsionModule = {
    namespaced: true,
    state: {
        previsiones: [],
        previsiones_inp: [],
        prevision_apv: [],
        isLoading: false,
        error: null,
    },
    mutations: {
        SET_PREVISIONES(state, previsiones) {
            state.previsiones = previsiones;
        },
        SET_PREVISIONES_INP(state, previsionesInp) {
            state.previsiones_inp = previsionesInp;
        },
        SET_PREVISION_APV(state, previsionApv) {
            state.prevision_apv = previsionApv;
        },
        SET_LOADING(state, isLoading) {
            state.isLoading = isLoading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
    },
    actions: {
        async fetchPrevision({ commit }) {
            commit('SET_LOADING', true);
            try {
                const { data } = await axios.get(`/prevision`);
                commit('SET_PREVISIONES', data);
            } catch (error) {
                commit('SET_ERROR', error.message);
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async fetchPrevisionInp({ commit }) {
            commit('SET_LOADING', true);
            try {
                const { data } = await axios.get(`/prevision_inp`);
                commit('SET_PREVISIONES_INP', data);
            } catch (error) {
                commit('SET_ERROR', error.message);
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async fetchPrevisionApv({ commit }) {
            commit('SET_LOADING', true);
            try {
                const { data } = await axios.get(`/ahorro-voluntario`);
                commit('SET_PREVISION_APV', data);
            } catch (error) {
                commit('SET_ERROR', error.message);
            } finally {
                commit('SET_LOADING', false);
            }
        },
    },
    getters: {
        previsiones: state => state.previsiones,
        previsionesInp: state => state.previsiones_inp,
        previsionApv: state => state.prevision_apv,
        isLoading: state => state.isLoading,
        error: state => state.error,
    },
};
