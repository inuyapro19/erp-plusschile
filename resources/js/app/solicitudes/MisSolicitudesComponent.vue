<template>
    <!-- Nesting -->
    <div>
        <div class="media mb-5">
            <img class="meta-usr-img rounded mr-5" :src="'/assets/img/90x90.jpg'" width="50" alt="pic1">
            <div class="media-body" >
                <h4 class="media-heading" style="text-transform: uppercase">{{ solicitudrespuestas.asunto +' - '+solicitudrespuestas.tipo_solicitud}}</h4>
                <p class="media-text" style="border: 1px solid #CDCDCD;max-width: 700px;border-radius: 5px;font-size: 20px;padding: 20px" v-html="solicitudrespuestas.comentario"></p>
                <p v-if="solicitudrespuestas.tipo_solicitud == 'modificación de datos'">
                    <span>Direccion: {{datos.direccion}}</span><br>
                    <span>Región: {{obtieneRegions}}</span>

                </p>
                <div v-if="solicitudrespuestas.tipo_solicitud == 'modificación de datos'">
                    <div class="archivos" v-for="(archivos, index) in solicitudrespuestas.archivo_solicitudes" >
                        <a :href="'/upload/solicitudes/certificado_direccion/'+archivos.nombre_archivo" :title="solicitudrespuestas.tipo_solicitud" class="btn btn-danger btn-sm" target="_blank"><i class="fa fa-cloud-download-alt"></i> Descargar</a>
                    </div>
                </div>
                <div v-if="solicitudrespuestas.tipo_solicitud == 'certificado antiguidad'">
                    <div class="archivos" v-for="(archivos, index) in solicitudrespuestas.archivo_solicitudes" >
                        <div class="alert alert-warning">Este archivo es autogenerado. debe esperar el archivo firmado para poder usarlo</div>
                        <a :href="'/upload/solicitudes/certificado_antiguidad/'+archivos.nombre_archivo" :title="solicitudrespuestas.tipo_solicitud" class="btn btn-danger btn-sm" target="_blank"><i class="fa fa-cloud-download-alt"></i> Previsializar</a>
                    </div>
                </div>
                <div class="media mt-3 mb-2" v-for="(respuestas, index) in solicitudrespuestas.respuestas_solicitudes">
                    <a class="meta-usr-img mr-5" href="javascript:void(0);">
                        <img class="rounded" :src="'/assets/img/90x90.jpg'" width="50" alt="pic2">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">{{respuestas.asunto}}</h4>
                        <p class="media-text" style="font-size:18px" v-html="respuestas.mensaje"></p>
                        <div v-if="solicitudrespuestas.tipo_solicitud == 'certificado antiguidad'">
                            <div class="archivos" v-if="respuestas.archivos" >
                                <a :href="'/upload/solicitudes/certificado_antiguidad_firmados/'+respuestas.archivos" :title="solicitudrespuestas.tipo_solicitud" class="btn btn-danger btn-sm" target="_blank"><i class="fa fa-cloud-download-alt"></i> Descargar</a>
                            </div>
                        </div>
                        <div v-if="solicitudrespuestas.tipo_solicitud == 'copia de contrato'">
                            <div class="archivos" v-if="respuestas.archivos" >
                                <a :href="'/upload/solicitudes/contratos/'+respuestas.archivos" :title="solicitudrespuestas.tipo_solicitud" class="btn btn-danger btn-sm" target="_blank"><i class="fa fa-cloud-download-alt"></i> Descargar</a>
                            </div>
                        </div>
                        <p>Respuesta enviada por: <span style="color: #000;font-weight: bold">{{respuestas.user.name+' '+respuestas.user.apellidos}}</span> </p>
                    </div>
                </div>
            </div>



        </div>

        <form @submit.prevent="enviar_respuesta">
            <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
            <div class="row">
                <div class="form-group col-md-10">
                    <label for="comentario">Respuesta</label>
                    <ckeditor v-model="mensaje" ></ckeditor>
                </div>
            </div>
            <div class="row">
                <!-- Submit Field -->
                <div class="form-group col-md-12" >
                    <button class="btn btn-success btn-sm" type="submit">Enviar</button>
                </div>
            </div>
        </form>
    </div>

</template>

<script>
export default {
    props:{
      id:Number
    },
    computed:{
        obtieneRegions:function (){
            let id = this.datos.region
            console.log(this.datos.region)
           let region = this.regiones.find((item)=> item.id === id)

            return region.nombre_region

        }
    },
    data() {
        return {
            solicitudrespuestas: [],
            mensaje:'',
            respuesta:false,
            alerta:'',
            mensajes:'',
            errors:[],
            inputClass:'form-control mb-4',
            errorsClass:'',
            edit:false,
            datos:[],
            regiones:[],
            comuna:[],
        }
    },
    mounted() {
        this.cargarSolicitudes()
        this.cargarState()
    },
    methods: {
         cargarSolicitudes:function (){
             let id = this.id
             axios.get('/getRespuestas/'+id).then((res)=>{
                 this.solicitudrespuestas = res.data
                 // this.conversations = JSON.parse(this.conversations.message);
               let datos =  JSON.parse(this.solicitudrespuestas.datos)
                 this.datos = datos
                 console.log(datos)

             }).catch((error)=>{
                console.log(error)
             })
         },
        enviar_respuesta:function (){
            // alert('hola')
             let id = this.id
            let formData = new FormData()
            formData.append('mensaje',this.mensaje)

            if (this.solicitudrespuestas.tipo_solicitud == 'modificación de datos'){
                formData.append('direccion',this.datos.direccion)
                formData.append('comuna_id',this.datos.comuna)
                formData.append('region_id',this.datos.region)
            }



            axios.post('/solicitude-trabajador-respuestas/'+id, formData,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((res)=> {
                this.respuesta = true
                this.alerta = 'alert-success'
                this.mensajes = 'Su respuesta ha sido enviada, dentro de un plazo de 48 sera procesada'
                this.cargarSolicitudes()
            }).catch((error)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al enviar el formulario'
                this.errorsClass = 'form-control is-invalid';
            })
        },
        cargarState:function(){
            axios.get('/regiones').then(res=>{
                this.regiones = res.data
            })
        },
        cargarCities:function(){
            let id = this.region

            axios.get('/comunas/'+id).then(res=>{
                //this.formulario.comuda_id = '0'
                this.comuna = res.data
            })
        },
    },

}
</script>

<style scoped>

</style>
