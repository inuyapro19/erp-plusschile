export async function generateID({commit},id){
    commit('generateID',id)
}

export async function addAhorro({commit}){
    commit('addAhorro')
}

export async function getAhorrosEdit({commit},datos)
{
    commit('getAhorroTrabajadorEdit',datos)
}
export async function deleteAhorro({commit}, id){
    commit('removeAhorro', id)
}
export async function  obtenerAhorro({ commit }, id) {
    commit('AhorroSelected', id)
}

export async function updateAhorro({commit},datos){
    commit('updateAhorro',datos)
}

export async function cambiar_estado({commit},datos){
    commit('cambiar_terminos',datos)
}
