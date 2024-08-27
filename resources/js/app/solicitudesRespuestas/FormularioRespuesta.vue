<template>
    <!-- Nesting -->
    <div>
        <div class="media mb-5">
            <img class="meta-usr-img rounded mr-5" :src="'/assets/img/90x90.jpg'" width="50" alt="pic1">
            <div class="media-body" >
                <h4 class="media-heading" style="text-transform: uppercase">{{ solicitudrespuestas.asunto +' - '+solicitudrespuestas.tipo_solicitud}}</h4>
                <p class="media-text" style="border: 1px solid #CDCDCD;max-width: 700px;border-radius: 5px;font-size: 20px;padding: 20px" v-html="solicitudrespuestas.comentario"></p>
                <p>Enviado por: {{solicitudrespuestas.trabajador.primer_nombre+' '+solicitudrespuestas.trabajador.primer_apellido }}</p>
                <div  v-if="solicitudrespuestas.tipo_solicitud == 'certificado antiguidad'">

                    <div class="archivos" v-for="(archivos, index) in solicitudrespuestas.archivo_solicitudes">
                        <a :href="'/upload/solicitudes/certificado_antiguidad/'+archivos.nombre_archivo" :title="solicitudrespuestas.tipo_solicitud" class="btn btn-danger btn-sm mt-2 mb-2" target="_blank"><i class="fa fa-cloud-download-alt"></i> Descargar</a>
                    </div>
                </div>
                <div  v-if="solicitudrespuestas.tipo_solicitud == 'modificación de datos'">
                    <p>
                        <span>Direccion: {{datos.direccion}}</span><br>
                        <span>Región: {{obtieneRegions}}</span>
                    </p>

                    <div class="archivos" v-for="(archivos, index) in solicitudrespuestas.archivo_solicitudes">
                        <a :href="'/upload/solicitudes/certificado_direccion/'+archivos.nombre_archivo" :title="solicitudrespuestas.tipo_solicitud" class="btn btn-danger btn-sm mt-2 mb-2" target="_blank"><i class="fa fa-cloud-download-alt"></i> Descargar</a>
                    </div>
                </div>
                <div  v-if="solicitudrespuestas.tipo_solicitud == 'carga familiar'">


                        <table class="table table-striped">
                            <thead>
                            <th>Rut</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Fecha Nac.</th>
                            <th>Fecha Termino</th>
                            <th>Parentesco</th>
                            </thead>
                            <tbody v-for="(familiares, index) in datos">
                                <tr v-for="(familiar, index) in familiares">
                                    <td>{{familiar.rut}}</td>
                                    <td>{{familiar.nombres}}</td>
                                    <td>{{familiar.apellidos}}</td>
                                    <td>{{ familiar.fecha_nacimiento | moment("DD-MM-YYYY")}}</td>
                                    <td>{{familiar.fecha_vencimiento_carga | moment("DD-MM-YYYY")}}</td>
                                    <td>{{familiar.parentesco_id}}</td>
                                </tr>
                            </tbody>
                        </table>


                    <div class="archivos" v-for="(archivos, index) in solicitudrespuestas.archivo_solicitudes">
                        <a :href="'/upload/solicitudes/certificados_nac/'+archivos.nombre_archivo" :title="solicitudrespuestas.tipo_solicitud" class="btn btn-danger btn-sm mt-2 mb-2" target="_blank"><i class="fa fa-cloud-download-alt"></i> Descargar</a>
                    </div>
                </div>

                <div v-if="solicitudrespuestas.tipo_solicitud == 'cambio cuenta bancaria'">
                    <table class="table table-striped">
                        <thead>
                        <th>Nro Cuenta</th>
                        <th>Tipo de cuenta</th>
                        <th>Banco</th>
                        <th>Fecha Ingreso Cuenta</th>
                        <th>Acciones</th>
                        </thead>
                        <tbody v-for="(banco, index) in datos">
                        <tr  v-for="(bancos, index) in banco">
                            <td>{{bancos.nro_cuenta}}</td>
                            <td>{{bancos.tipo_cuenta}}</td>
                            <td>{{bancos.nombre_banco}}</td>
                            <td>{{bancos.fecha_ingreso_cuenta | moment("DD-MM-YYYY")}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="media mt-3 mb-2" v-for="(respuestas, index) in solicitudrespuestas.respuestas_solicitudes">
                    <a class="meta-usr-img mr-5" href="javascript:void(0);">
                        <img class="rounded" :src="'/assets/img/90x90.jpg'" width="50" alt="pic2">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">{{respuestas.asunto}}</h4>
                        <p class="media-text" v-html="respuestas.mensaje"></p>
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
            <div class="row" v-if="solicitudrespuestas.tipo_solicitud == 'copia de contrato'">
                <div class="col-md-6 form-group">
                    <div class="form-group col-md-8">
                        <label for="file-upload">Contrato</label>
                        <input   ref="contrato"  id="file-upload"  type="file" aria-label="Adjunte archivo de contrato" @change.prevent="onFileChangeContrato()"    accept=".pdf" />
                    </div>
                </div>
            </div>
            <div class="row" v-if="solicitudrespuestas.tipo_solicitud == 'certificado antiguidad'">
                <div class="col-md-6 form-group">
                    <div class="form-group col-md-8">
                        <label for="file-upload">Contrato</label>
                        <input   ref="certificado"  id="file-upload"  type="file" aria-label="Adjunte archivo de certificado" @change.prevent="onFileChangeCertificado()"    accept=".pdf" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-10">
                    <label for="comentario">Respuesta</label>
                    <ckeditor v-model="mensaje" ></ckeditor>
                </div>
            </div>
            <div class="row">
                <div class="filtro mt-2 mb-3 col-md-4">
                    <label for="">Estado</label>
                    <select name="estado" id="estado" v-model="solicitudrespuestas.estado" class="form-control">
                        <option value="">-----------</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="en proceso">En Proceso</option>
                        <option value="finalizado">Finalizado</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <!-- Submit Field -->
                <div class="form-group col-md-12" >
                    <button class="btn btn-success btn-sm" type="submit" :disabled="estado_finalizado">Enviar</button>
                </div>
            </div>
        </form>
    </div>

</template>

<script>
export default {
   name:'formulario-respuestas',
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
            datos:'',
            regiones:[],
            comuna:[],
            contrato:[],
            certifcado:[],
            estado:'',
            estado_finalizado:false
        }
    },
    mounted() {
        this.cargarSolicitudes()
        this.cargarState()
        this.estaFinalizado()
    },
    methods: {
        cargarSolicitudes:function (){
            let id = this.id
            axios.get('/getSolicitudesRespuestas/'+id).then((res)=>{
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
            formData.append('estado',this.solicitudrespuestas.estado)
            formData.append('tipo_solicitud',this.solicitudrespuestas.tipo_solicitud)

            if (this.solicitudrespuestas.tipo_solicitud === 'copia de contrato'){
                formData.append('contrato',this.contrato)
            }

            if (this.solicitudrespuestas.tipo_solicitud === 'certificado antiguidad'){
                formData.append('certificado',this.certifcado)
            }

            if (this.solicitudrespuestas.tipo_solicitud == 'modificación de datos'){
                formData.append('direccion',this.datos.direccion)
                formData.append('comuna_id',this.datos.comuna)
                formData.append('region_id',this.datos.region)
            }

            if (this.solicitudrespuestas.tipo_solicitud ===  'carga familiar'){
                 formData.append('carga_familiar',this.datos)
            }

            axios.post('/solicitude-admin-respuestas/'+id, formData,{
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
        onFileChangeContrato() {
            //console.log(e.target.files[0]);
            //this.filename =   this.$certificado.file.files[0].name;
            // this.size =  this.file = this.$certificado.file.files[0].size;
            this.contrato = this.$refs.contrato.files[0];
        },
        onFileChangeCertificado:function (){
            this.certifcado = this.$refs.certificado.files[0];
        },
        estaFinalizado:function (){
            let estado = this.solicitudrespuestas.estado

            if (estado === 'finalizado'){
                this.estado_finalizado = true
            }
            else {
                this.estado_finalizado = false
            }
        }

    },

}
</script>
<style scoped>

</style>
