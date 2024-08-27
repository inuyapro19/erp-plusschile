export async function siente_porciento({commit},payload){
    commit('siente_porciento',payload)
}

export async function habilitarMonto({commit},payload){
    commit('habilitarMonto',payload)
}
export async function cargarSaludEdit({commit},data){
    commit('cargarSaludEdit',data)
}
