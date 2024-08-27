import axios from 'axios';


export const trabajadoresModule = {
    namespaced: true,
    state: {
        trabajadores: [],
        trabajadores_unlink: [],
        isLoading: false,
        error: null,
    },
    mutations: {
        SET_LOADING(state, isLoading) {
            state.isLoading = isLoading;
        },
        SET_TRABAJADORES(state, trabajadores) {
            state.trabajadores = trabajadores;
        },
        SET_TRABAJADORES_UNLINK(state, trabajadoresUnlink) {
            state.trabajadores_unlink = trabajadoresUnlink;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
    },
    actions: {
        async fetchTrabajadores({ commit }, params = {}) {
            commit('SET_LOADING', true);
            try {
                let url = `/getTrabajadores`;
                const queryParams = new URLSearchParams(params).toString();
                if (queryParams) url += `?${queryParams}`;
                const { data } = await axios.get(url);
                commit('SET_TRABAJADORES', data);
            } catch (error) {
                commit('SET_ERROR', error.message);
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async fetchTrabajadorById({ commit }, id) {
            commit('SET_LOADING', true);
            try {
                const { data } = await axios.get(`/getTrabajador/${id}`);
                commit('SET_TRABAJADORES', data); // Assuming response needs to be in an array
            } catch (error) {
                commit('SET_ERROR', error.message);
            } finally {
                commit('SET_LOADING', false);
            }
        },
        // Add other actions similarly (addTrabajador, editTrabajador, unlinkTrabajador, getTrabajadoresUnlink)
        async getTrabajadoresUnlink({ commit }, id) {
            commit('SET_LOADING', true);
            try {
                const { data } = await axios.get(`/getTrabajadoresUnlink/${id}`);
                commit('SET_TRABAJADORES_UNLINK', data);
            } catch (error) {
                commit('SET_ERROR', error.message);
            } finally {
                commit('SET_LOADING', false);
            }
        },
        // Asegúrate de importar Axios correctamente en tu store Vuex o donde lo necesites
        async addTrabajador({ commit }, trabajador) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.post(`/addTrabajador`, trabajador);
                commit('SET_TRABAJADORES', response.data);
                // Opcionalmente, puedes devolver datos aquí si necesitas manejarlos después de la llamada
            } catch (error) {
                commit('SET_ERROR', error.message);
                throw error; // Lanza el error para manejarlo en el método onSubmit
            } finally {
                commit('SET_LOADING', false);
            }
        },

        async editTrabajador({ commit }, trabajador) {
            commit('SET_LOADING', true);
            try {
                const { data } = await axios.put(`/editTrabajador`, trabajador);
                commit('SET_TRABAJADORES', data);
            } catch (error) {
                commit('SET_ERROR', error.message);
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async unlinkTrabajador({ commit }, trabajador) {
            commit('SET_LOADING', true);
            try {
                const { data } = await axios.put(`/unlinkTrabajador`, trabajador);
                commit('SET_TRABAJADORES', data);
            } catch (error) {
                commit('SET_ERROR', error.message);
            } finally {
                commit('SET_LOADING', false);
            }
        },


    },
    getters: {
        trabajadores: state => state.trabajadores,
        trabajadoresUnlink: state => state.trabajadores_unlink,
        isLoading: state => state.isLoading,
        error: state => state.error,
    },
};
