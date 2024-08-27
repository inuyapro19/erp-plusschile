export function esInp(state){
    state.isInp = true
    state.isAfp =false
}
export function esAfp(state){
    state.isAfp =true
    state.isInp =false
}
export function cargarPrevisiones(state,data){
    state.prevision={
        tipo_prevision:data.tipo_entidad,
        prevision_id:data.prevision_id,
        inp_id:data.inp_id
    }
}
