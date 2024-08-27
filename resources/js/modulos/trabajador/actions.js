
export async function licencia({commit}){
    commit('licencia');
}

export async function addFamiliar({commit},payload){
    commit('addFamiliar',payload)
}

export async function removeFamiliar({commit},payload){
    commit('removeFamiliar',payload)
}

export async function cargarTrabajadorEdit({commit},id){
    await axios.get('/trabajadores/'+id).then((res) =>{

        commit('cargaTrabajador',res.data)
    })
}

export async function trabajador_perfil({commit},rut){
    await axios.get('/getPerfil/'+rut).then((res)=>{
        commit('cargarTrabajador',res.data)
    }).catch((error)=>{
        console.log(error);
    })
}
