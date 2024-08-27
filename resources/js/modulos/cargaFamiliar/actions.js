export async function generateID({commit},id){
    commit('generateID',id)
}

export async function addCargaFamiliar({commit}){
    commit('addCargaFamiliar')
}

export async function deleteCargaFamiliar({commit}, id){
    commit('removeCargaFamiliar', id)
}

export async function  obtenerCargaFamiliar({ commit }, id) {
    commit('CargaFamiliarSelected', id)
}

export function cargaFamiliarEdit({commit},datos){
    commit('cargaFamiliarEdit',datos)
}

export function updateCargaFamiliar({commit},datos){
    commit('updateCargaFamiliar',datos)
}

export async function Addcertificados({commit},datos){
    commit('Addcertificados',datos)
}


