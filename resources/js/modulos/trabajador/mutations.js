
export function  licencia (state) {
        // mutate state
        state.licencia_conducir = !state.licencia_conducir
}

export function addFamiliar( state , payload){
        state.carga_familiar.push(payload)
}

export function removeFamiliar(state , payload){
    state.carga_familiar.splice(payload,1)
}

export function cargaTrabajador(state, data){
    //console.log(data.rut)
    state.allDatos = data
    console.log(state.allDatos.contrato)
    state.formulario = {
        id:data.id,
        codigo_trabajador:data.codigo_trabajador,
        rut:data.rut,
        primer_nombre: data.primer_nombre,
        segundo_nombre:data.segundo_nombre,
        primer_apellido:data.primer_apellido,
        segundo_apellido:data.segundo_apellido,
        fecha_nac:data.fecha_nac,
        correo:data.correo,
        telefono_opcional:data.telefono_local,
        telefono_obligatorio:data.telefono_celular,
        direccion:data.direccion,
        comuna_id:data.comuna_id,
        region_id:data.region_id,
        grado_escolaridad:data.grado_escolaridad,
        estado_civil:data.estado_civil,
        sexo:data.sexo,
        nacionalidad:data.nacionalidad_id,
        perteneces_pueblo_originario:data.pertenece_pueblo_originario==='si' ? true : false,
        pueblo_originario_id:data.pueblo_originario_id  ? data.pueblo_originario_id  : 0,
        tiene_familia:data.tiene_familia==='si' ? true : false,
        tiene_discapacidad:data.tiene_discapacidad==='si' ? true : false
    }
}

export function cargarTrabajador(state, data){
    state.trabajador = data;
}





