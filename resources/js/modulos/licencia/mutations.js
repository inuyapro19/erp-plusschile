
export function generateID(state,payload)
{
    state.licencia.id = payload
}

export function addLicencia(state) {
    state.licencias.push(state.licencia)
    state.licencia = {
        id:'',
        tipo_licencia:0,
        nro_serie:'',
        fecha_de_ingreso:'',
        fecha_de_vencimiento:'',
    }
}
export function removeLicencia(state, payload) {
    state.licencias = state.licencias.filter(item => item.id !== payload)

    state.licencia = {
        id:'',
        tipo_licencia:0,
        nro_serie:'',
        fecha_de_ingreso:'',
        fecha_de_vencimiento:'',
    }
}
export function LicenciaSelected(state, payload) {
    state.licencia = state.licencias.find(item => item.id === payload)
    //console.log('tarea vuex: ', state.tarea)
}

export function reset_contacto(state){
    state.contacto = []
}
