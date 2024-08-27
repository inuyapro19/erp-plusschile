<template>
    <div>
        <form  @submit.prevent="enviarFormulario">
            <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>

            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="numero_bus">Nro de bus</label>
                    <input type="number" v-model="numero_bus" id="numero_bus" class="form-control" >
                </div>
                <div class="col-md-4 form-group">
                    <label for="marca">Marca de bus</label>
                    <input type="text" v-model="marca" id="marca" class="form-control" >
                </div>
                <div class="col-md-4 form-group">
                    <label for="modelo">Modelo de bus</label>
                    <input type="text" v-model="modelo" id="modelo" class="form-control" >
                </div>
                <div class="col-md-4 form-group">
                    <label for="marca_de_motor">Marca de motor</label>
                    <input type="text" v-model="marca_motor" id="marca_de_motor" class="form-control" >
                </div>
                <div class="col-md-4 form-group">
                    <label for="patente">Patente</label>
                    <input type="text" v-model="patente" id="patente" class="form-control" >
                </div>
                <div class="col-md-4 form-group">
                    <label for="tipo_servicio">Tipo servicio</label>
                    <select v-model="tipo_servicio" id="tipo_servicio" class="form-control">
                        <option value="">-----------</option>
                        <option value="comercial">Comercial</option>
                        <option value="minero">Minero</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="empleador_id">Propietario</label>
                    <select name="empleador_id" v-model="empleador_id" id="empleador_id" class="form-control">
                        <option value="">-------</option>
                        <option v-for="(propietario, index) in empleadores" :value="propietario.id">{{propietario.nombre_empleador}}</option>
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label for="anyo">Año del bus</label>
                    <input type="number" v-model="anyo_bus" id="anyo" class="form-control" >
                </div>
                <div class="col-md-4 form-group">
                    <label for="numero_asientos">Numero de asientos</label>
                    <input type="text" v-model="numero_asientos" id="numero_asientos" class="form-control" >
                </div>
                <div class="col-md-4 form-group">
                    <label for="numero_pantallas">Numero pantallas</label>
                    <input type="text" v-model="numero_pantallas" id="numero_pantallas" class="form-control" >
                </div>

            </div>
            <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
            <a href="/buses" class="btn btn-default btn-sm">Volver</a>
        </form>
    </div>
</template>

<script>
export default {
    props:{
        id:Number
    },
    data() {
        return {
            estado_condiciones:[
                'Avería en la vía',
                'Bus operativo',
                'Nombre_causas',
                'Mantención preventiva',
                'Sustitución de otro bus',
                'Viaje Especial'
            ],
            mensaje:'',
            respuesta:false,
            alerta:'',
            mensajes:'',
            errors:[],
            inputClass:'form-control mb-4',
            errorsClass:'',
            empleadores:[],
            buses:[],
            edit:true,
            numero_bus:'' ,
            marca:'' ,
            modelo:'',
            marca_motor:'' ,
            patente:'' ,
            empleador_id:0,
            anyo_bus:'',
            numero_asientos:'' ,
            numero_pantallas:'',
            tipo_servicio:'',

        }
    },
    mounted() {
        this.cargarEmpleador()
        this.cargaDatosBuses()
    },
    methods: {
       async cargarEmpleador (){
           await axios.get('/empleador').then(res=>{
                this.empleadores = res.data
            })
        },
       async cargaDatosBuses (){
            let id = this.id
           await axios.get('/getBuses/'+id).then((res)=>{

                this.buses = res.data
               if (this.edit){
                       this.numero_bus = this.buses.numero_bus
                       this.marca = this.buses.marca
                       this.modelo = this.buses.modelo
                       this.marca_motor = this.buses.marca_motor
                       this.patente = this.buses.patente
                       this.empleador_id = this.buses.empleador_id
                       this.anyo_bus = this.buses.anyo_bus
                       this.numero_asientos = this.buses.numero_asientos
                       this.numero_pantallas = this.buses.numero_pantallas
                       this.tipo_servicio = this.buses.tipo_servicio
                       this.estado = this.buses.estado
               }

            }).catch((error)=>{
                console.log('error')
            })
        },
       async enviarFormulario (){

            let formData = new FormData()

           formData.append('numero_bus',this.numero_bus)
           formData.append('marca',this.marca)
           formData.append('modelo',this.modelo)
           formData.append('patente',this.patente)
           formData.append('marca_motor',this.marca_motor)
           formData.append('empleador_id',this.empleador_id)
           formData.append('anyo_bus',this.anyo_bus)
           formData.append('numero_asientos',this.numero_asientos)
           formData.append('numero_pantallas',this.numero_pantallas)
           formData.append('tipo_servicio',this.tipo_servicio)
            formData.append('estado',this.buses.estado)

           await axios.post('/buses/'+this.id,formData,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((res)=>{

                this.respuesta = true
                this.alerta = 'alert-success'
                this.mensajes = 'Bus editado exitosamente'

            }).catch((error)=>{

                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al enviar el formulario'
                this.errorsClass = 'form-control is-invalid';
                console.log(error)

            })

        }
    },
}
</script>

<style scoped>

</style>
