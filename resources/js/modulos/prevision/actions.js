export async function esInp({commit}){
    commit('esInp')
}
export async function esAfp({commit}){
    commit('esAfp')
}
export async function cargarPrevisionEdit({commit},data){
        commit('cargarPrevisiones',data)
}
