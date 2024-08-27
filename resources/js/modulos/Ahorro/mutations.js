export function generateID(state,payload)
{
    state.ahorro.id = payload
}

export function addAhorro(state) {
    state.ahorros.push(state.ahorro)
    state.ahorro = {
        tipo_ahorro:'',
        ahorro_voluntario_id:'',
        tipo_moneda:'',
        monto:0,
        forma_pago:''
    }
}

export function getAhorroTrabajadorEdit(state,datos){
    state.ahorros = datos
}
export function removeAhorro(state, payload) {
    state.ahorros = state.ahorros.filter(item => item.id !== payload)
    state.ahorro = {
        id:'',
        tipo_ahorro:'',
        ahorro_voluntario_id:'',
        tipo_moneda:'',
        monto:0,
        forma_pago:'',
        fecha_ingreso:'',
        fecha_vencimiento:'2099-12-31',
    }
}
export function AhorroSelected(state, payload) {
    state.mostareditarContacto = true;
    state.mostraragregarContacto=false;
    state.ahorro = state.ahorros.find(item => item.id === payload)
    //console.log('tarea vuex: ', state.tarea)
}

export function updateAhorro(state, datos){
    state.ahorros = state.ahorros.map(item => item.id === datos.id ? datos : item)
    state.mostareditarContacto = false;
    state.mostraragregarContacto=true;
    state.ahorro = {
        id:'',
        tipo_ahorro:'',
        ahorro_voluntario_id:'',
        tipo_moneda:'',
        monto:0,
        forma_pago:'',
        fecha_ingreso:'',
        fecha_vencimiento:'2099-12-31',
    }
}

export function cambiar_terminos(state, datos){
   if( datos === true)
   {
       state.terminos = true
   }else{
       state.terminos = false
   }

}
