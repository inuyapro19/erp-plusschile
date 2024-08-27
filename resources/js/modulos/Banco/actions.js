

export async function generateID({commit},id){
    commit('generateID',id)
}

export async function addBancos({commit}){
    commit('addBancos')
}
export async function deleteBanco({commit}, id){
    commit('removeBanco', id)
}
 export async function  obtenerBanco({ commit }, id) {
     commit('bancoSelected', id)
 }

 export async function fitrarBanco({commit},payload)
 {
     commit('fitrarBanco',payload)
 }

 export async function getBancoTrabajadorEdit({commit},datos)
 {
     commit('getBancoTrabajadorEdit',datos)
 }

 export async function setNombreBanco({commit},datos){
    commit('setNombreBanco',datos)
 }
export async function updateBancos({commit},datos){
    commit('updateBancos',datos)
}
