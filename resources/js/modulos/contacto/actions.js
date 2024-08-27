export async function generateID({commit},id){
    commit('generateID',id)
}

export async function addContactos({commit}){
    commit('addContacto')
}

export async function deleteContacto({commit}, id){
    commit('removeContacto', id)
}

export async function  obtenerContacto({ commit }, id) {
    commit('ContactoSelected', id)
}

export async function  comprobar_maximo({ commit }) {
    commit('comprobar_maximo')
}

export async function reset_contacto({commit}){
    commit('reset_contacto')
}

export async function GetContrato({commit},datos)
{
    commit('getContrato')
}

export async function cargarContactoEdit({commit},datos){
    commit('cargarContactoEdit',datos)
}

export async function updateContacto({commit},datos){
    commit('updateContacto',datos)
}
