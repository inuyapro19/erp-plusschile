export const cargarAreas = async (filtros = '') => {
    const {data, status} = await axios.get('/areas')
    if (status === 200) {
        return data
    }
}

export const cargarBancos = async ()=>
{
    const {data, status} = await axios.get('/bancos')
    if (status === 200) {
        return data
    }
}


export const cargarCargos = async ()=>{
   const {data,status} =await axios.get('/cargos')
    if(status === 200)
    {
         return data
    }
}

export const cargarEmpleador = async ()=>{
   const {data , status}= await  axios.get('/empleador')
    if (status === 200)
    {
        return data
    }
}


export const  cargarUbicaciones = async ()=>{
    try {
        const {data, status} = await axios.get('/ubicaciones')
        if (status === 200){
           return  data
        }
    }
    catch (e) {
        console.log(e)
    }
}
export const getTrabajadores = async ()=>{
    try {
        const {data, status} = await axios.get('/trabajadores')
        if (status === 200){
           return  data
        }

    }
    catch (e) {
        console.log(e)
    }
}


export const cargarCategorias = async ()=>{
    try {
        const {data, status} = await axios.get('/checklist/categoria')
        if (status === 200){
           return  data
        }

    }
    catch (e) {
        console.log(e)
    }
}
