
export function generateID(state,payload)
{
    state.bancotrabajador.id = payload
}

export function addBancos(state) {
    state.bancotrabajadores.push(state.bancotrabajador)
    state.bancotrabajador = {
        id:'',
        banco_id:'',
        nombre_banco:'',
        nro_cuenta:'',
        tipo_cuenta:'',
        fecha_ingreso_cuenta:'',
        predeterminado:''
    }
}

export function fitrarBanco(state, payload){
    state.bancotrabajador.nombre_banco = payload
}

export function removeBanco(state, payload) {
    state.bancotrabajadores = state.bancotrabajadores.filter(item => item.id !== payload)
    state.bancotrabajador = {
        id:'',
        banco_id:'',
        nombre_banco:'',
        nro_cuenta:'',
        tipo_cuenta:'',
        fecha_ingreso_cuenta:'',
        predeterminado:''
    }
}

export function bancoSelected(state, payload) {
    state.mostareditarContacto = true;
    state.mostraragregarContacto=false;
    state.bancotrabajador = state.bancotrabajadores.find(item => item.id === payload)
    //console.log('tarea vuex: ', state.tarea)
}


export function getBancoTrabajadorEdit(state,datos){
    state.bancotrabajadores = datos
}

export function setNombreBanco(state,datos){
    state.bancotrabajador.nombre_banco = datos
}

export function updateBancos(state, datos){
    state.bancotrabajadores = state.bancotrabajadores.map(item => item.id === datos.id ? datos : item)
    state.mostareditarContacto = false;
    state.mostraragregarContacto=true;
    state.bancotrabajador = {
        id:'',
        banco_id:'',
        nombre_banco:'',
        nro_cuenta:'',
        tipo_cuenta:'',
        fecha_ingreso_cuenta:'',
        predeterminado:''
    }
}
