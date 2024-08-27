
export function generateID(state,payload)
{
    state.cargaFamiliar.id = payload
}

export function addCargaFamiliar(state) {
    state.cargasFamiliares.push(state.cargaFamiliar)
    state.cargaFamiliar={
        id:'',
        rut:'',
        nombres:'',
        apellidos:'',
        fecha_nacimiento:'',
        fecha_indefinida:false,
        fecha_vencimiento_carga:'2099-12-31',
        parentesco_id:0,
        parentenco:'',
        certificado_nac:''
    }
}
export function removeCargaFamiliar(state, payload) {
    state.cargasFamiliares = state.cargasFamiliares.filter(item => item.id !== payload)

    state.cargaFamiliar={
        id:'',
        rut:'',
        nombres:'',
        apellidos:'',
        fecha_nacimiento:'',
        fecha_indefinida:false,
        fecha_vencimiento_carga:'2099-12-31',
        parentesco_id:0,
        parentenco:'',
        certificado_nac:''
    }
}
export function CargaFamiliarSelected(state, payload) {
    state.mostareditarContacto = true;
    state.mostraragregarContacto=false;
    state.cargaFamiliar = state.cargasFamiliares.find(item => item.id === payload)
}

export function cargaFamiliarEdit(state, datos){
    state.cargasFamiliares = datos
}

export function updateCargaFamiliar(state, datos){
    state.cargasFamiliares = state.cargasFamiliares.map(item => item.id === datos.id ? datos : item)
    state.mostareditarContacto = false;
    state.mostraragregarContacto=true;
    state.cargaFamiliar={
        id:'',
        rut:'',
        nombres:'',
        apellidos:'',
        fecha_nacimiento:'',
        fecha_indefinida:false,
        fecha_vencimiento_carga:'2099-12-31',
        parentesco_id:0,
        parentenco:'',
        certificado_nac:''
    }
}

export function Addcertificados(state, datos){
    state.certificados_nac.push({file:datos})
}
