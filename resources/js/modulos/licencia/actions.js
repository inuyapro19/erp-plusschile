export async function generateID({commit},id){
    commit('generateID',id)
}

export async function addLicencia({commit}){
    commit('addLicencia')
}

export async function deleteLicencia({commit}, id){
    commit('removeLicencia', id)
}

export async function  obtenerLicencia({ commit }, id) {
    commit('LicenciaSelected', id)
}

export async function reset_contacto({commit}){
    commit('reset_contacto')
}
