
export function generateID(state,payload)
{
    state.contactoForm.id = payload
}

export function addContacto(state) {
    state.contacto.push(state.contactoForm)
    state.contactoForm = {
        id:'',
        nombre:'',
        apellido:'',
        telefono:'',
        correo:'',
        direccion:'',
        region_id:0,
        comuda_id:0
    }
}
export function removeContacto(state, payload) {
    state.contacto = state.contacto.filter(item => item.id !== payload)
    state.maximo_contacto = state.contacto.length;
    state.contactoForm = {
        id:'',
        nombre:'',
        apellido:'',
        telefono:'',
        correo:'',
        direccion:'',
        region_id:0,
        comuda_id:0
    }
}
export function ContactoSelected(state, payload) {
    state.mostareditarContacto = true;
    state.mostraragregarContacto=false;
    state.contactoForm = state.contacto.find(item => item.id === payload)
    //console.log('tarea vuex: ', state.tarea)
}

export function comprobar_maximo(state){
    state.maximo_contacto = state.contacto.length;
}

export function reset_contacto(state){
    state.contacto = []
}

export function cargarContactoEdit(state, datos){
    state.contacto = datos
}
export function updateContacto(state, datos){
    state.contacto = state.contacto.map(item => item.id === datos.id ? datos : item)
    state.mostareditarContacto = false;
    state.mostraragregarContacto=true;
    state.contactoForm = {
        id:'',
        nombre:'',
        apellido:'',
        telefono:'',
        correo:'',
        direccion:'',
        region_id:0,
        comuda_id:0
    }
}
