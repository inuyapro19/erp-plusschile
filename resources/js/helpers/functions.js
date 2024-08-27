/*module.exports.getViajes = async function () {
    //Obtienes el listado de viajes

        try {
            let url = '/getViajes?opcion=1';

            if (this.nro_viaje_filtro !== ''){
                url = url + '&filtro[nro_viaje]='+this.nro_viaje_filtro
            }
            //filtro por bus
            if (this.filtroporBus !== ''){
                url = url + '&filtroporBus='+this.filtroporBus
            }

            if (this.tipo_viaje_filtro !== ''){
                url = url + '&filtro[tipo_viaje]='+this.tipo_viaje_filtro
            }

            if (this.estado_filtro !== ''){
                url = url + '&filtro[estado]='+this.estado_filtro
            }else{
                url = url + '&estado_activos=EN RUTA'
            }

            const { data, status} = await axios.get(url)

            if (status === 200){
                this.viajes = data
            }

        }catch (e) {
            console.log(e)
        }
    }*/

    module.exports.getEmpleadores = async function () {
        //Obtienes el listado de empleadores
        try {
            const { data, status} = await axios.get('/getEmpleadores')
            if (status === 200){
                this.empleadores = data
            }
        }catch (e) {
            console.log(e)
        }
    }

    module.exports.getCargos = async function () {
        //Obtienes el listado de cargos
        try {
            const { data, status} = await axios.get('/getCargos')
            if (status === 200){
                this.cargos = data
            }
            console.log(this.cargos)
        }catch (e) {
            console.log(e)
        }

    }


