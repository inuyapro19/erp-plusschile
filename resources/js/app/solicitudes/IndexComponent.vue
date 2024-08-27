<template>
    <div>
        <form @submit.prevent="enviarFormulario">
            <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="asunto">Asunto</label>
                    <input type="text" v-model="asunto" id="asunto" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for="tipo_solicitud">Tipo solicitud</label>
                    <select name="tipo_solicitud" id="tipo_solicitud" class="form-control" v-model="tipo_solicitud" @change.prevent="cambioDeSolicitud">
                        <option value="">--Seleccione---</option>
                        <option value="copia de contrato">Copia de Contrato</option>
                        <option value="certificado antiguidad">Certificado antiguidad</option>
                        <option value="carga familiar">Carga Familiar</option>
                        <option value="modificacion de datos">Modificación de datos</option>
                        <option value="cambio cuenta bancaria">Cambio de Cuenta Bancaria</option>
                    </select>
                </div>
                <!---Ceriticado Antiguidad-->
            </div>
            <!---Ceriticado Antiguidad-->

            <div class="clearfix"></div>


            <div class="row" v-show="esCertificadoAntiguidad">
                <div class="form-group col-md-6">
                    <label for="uso_certificado">Seleccione el uso de certificado</label>
                    <select name="uso_certificado" id="uso_certificado" class="form-control" @change.prevent="cambiar_uso_certificado" v-model="uso_certificado">
                        <option value="">-----Seleccione Motivo----</option>
                        <option value="para fines que estimes convenientes">Para fines que estime convenientes</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                <div class="form-group col-md-6" v-show="otro_uso_certificado">
                    <label for="otro_uso">Escriba donde se usara el certificado</label>
                    <input type="text" v-model="otro_uso" class="form-control" id="otro_uso">
                </div>
                <div class="form-group col-md-6">
                    <label for="uso_certificado">Retiro</label>
                    <select name="uso_certificado" id="retiro_certificado" class="form-control"  v-model="retiro">
                        <option value="">-----Seleccione Forma de Retiro----</option>
                        <option value="por correo">Por Correo</option>
                        <option value="en oficina">En oficina de RRHH</option>
                        <option value="en intranet">En intranet</option>
                    </select>
                </div>
            </div>
            <div class="row" v-show="esCambioDatos">
                <div class="col-md-6 form-group">
                    <label for="cambios_datos">Que desea cambiar</label>
                    <select name="cambios_datos" v-model="tipo_datos_a_cambiar" id="cambios_datos" @change.prevent="cambiodatos" class="form-control">
                        <option value="">----------------</option>
                        <option value="direccion">Dirección</option>
                        <option value="telefono">Teléfono</option>
                    </select>
                </div>

            </div>
            <div class="row" v-show="esdireccion">
                <div class="col-md-4 form-group">
                    <label for="">Dirección</label>
                    <input type="text" name="direccion" class="form-control" v-model="direccion">
                </div>
                <div class="col-md-4 form-group">
                    <label for="region">Región</label>
                    <select name="" class="form-control" v-model="region" id="region" @change.prevent="cargarCitiesFiltro()">
                        <option value="">-----</option>
                        <option v-for="(region, index) in regiones"  :value="region.id">{{region.nombre_region}}</option>
                    </select>
                </div>

                <div class="col-sm-4 form-group">
                    <label for="">Comunas</label>
                    <select name="comuna" class="form-control" v-model="comuna" id="">
                        <option value="">-----</option>
                        <option v-for="(comuna, index) in comunas" :value="comuna.id">{{comuna.nombre_comuna}}</option>
                    </select>
                </div>

                <div class="col-md-6 form-group">
                    <div class="form-group col-md-8">
                        <label for="file-upload">Certificado Residencia</label>
                        <input   ref="certificado"  id="file-upload"  type="file" aria-label="Adjunte certificado de residencia" @change.prevent="onFileChangeResidencia()"    accept=".pdf" />
                    </div>
                </div>
            </div>
            <div class="row" v-show="esCargaFamiliar">
                <familiar></familiar>
                <div class="col-md-6 mt-3 mb-2">
                    <label for="">Certificados de nacimientos</label>
                    <input type="file" id="files" ref="certificado_nac" multiple @change="onFileChangeCertifacadoNac()" aria-label="Adjunte Certificado de nacimiento" accept=".pdf"/>
                </div>


            </div>
            <div class="row" v-show="esContrato">
                <div class="form-group col-md-6">
                    <label for="uso_certificado">Retiro</label>
                    <select name="uso_certificado" id="retiro_certificado" class="form-control"  v-model="retiro">
                        <option value="">-----Seleccione Forma de Retiro----</option>
                        <option value="por correo">Por Correo</option>
                        <option value="en oficina">En oficina de RRHH</option>
                        <option value="en intranet">En intranet</option>
                    </select>
                </div>
            </div>
            <div class="row" v-show="esCambioBanco">
                <Bancos></Bancos>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="comentario">Mensaje</label>
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
import familiar from './Formularios/Familiar'
import Bancos from "./Formularios/Bancos";
//import VueUploadMultipleImage from 'vue-upload-multiple-image'
import {mapState} from "vuex";
export default {
    components:{
        familiar,
        Bancos
    },
    computed:{
        ...mapState('cargaFamiliar',['cargasFamiliares','certificados_nac']),
        ...mapState('bancos',['bancotrabajadores'])
    },
    data() {
        return {
            asunto:'',
            retiro:'',
            mensaje:'',
            tipo_solicitud:'',
            uso_certificado:'',
            otro_uso:'',
            estado:'',
            otro_uso_certificado:false,
            esCertificadoAntiguidad:false,
            esContrato:false,
            esCambioBanco:false,
            esCambioDatos:false,
            esCargaFamiliar:false,
            respuesta:false,
            alerta:'',
            mensajes:'',
            errors:[],
            inputClass:'form-control mb-4',
            errorsClass:'',
            edit:false,
            tipo_datos_a_cambiar:'',
            estelefono:false,
            telefono1:'',
            telefono2:'',
            esdireccion:false,
            direccion:'',
            comuna:0,
            region:0,
            documento_direccion:'',
            regiones:[],
            comunas:[],
            arrayComunas:[],
            certificado_nacimientos:''
        }
    },

    methods: {
        enviarFormulario:function (){

           // alert('hola')
            let formData = new FormData()
            formData.append('asunto',this.asunto)
            formData.append('mensaje',this.mensaje)
            formData.append('tipo_solicitud',this.tipo_solicitud)

            switch(this.tipo_solicitud) {
                case 'copia de contrato':

                       let contrato = {
                           retiro:this.retiro
                       }
                      formData.append('datos',JSON.stringify(contrato))

                    break;
                case 'certificado antiguidad':
                    let datos_ant = {
                        uso_certificado:this.uso_certificado,
                        otro_uso_certificado:this.otro_uso_certificado,
                        retiro:this.retiro
                    }
                    formData.append('datos',JSON.stringify(datos_ant))
                    formData.append('uso_certificado',this.uso_certificado)
                    formData.append('otro_uso_certificado',this.otro_uso_certificado)

                    break;
                case 'carga familiar':
                    let familiar = []
                    familiar.push(this.cargasFamiliares)
                    formData.append('datos',JSON.stringify(familiar))
                    //formData.append('certificados',this.certificado_nacimientos)
                    for( var i = 0; i < this.$refs.certificado_nac.files.length; i++ ){
                        let file = this.$refs.certificado_nac.files[i];
                        formData.append('certificados[' + i + ']', file);
                    }
                    break;
                case 'modificacion de datos':
                        let datos = {
                            direccion:this.direccion,
                            comuna:this.comuna,
                            region:this.region,
                            documento_direccion:this.documento_direccion,
                        }
                        formData.append('datos',JSON.stringify(datos))
                        formData.append('documento_direccion',this.documento_direccion)
                    break;
                case "cambio cuenta bancaria":
                    let bancostraba = []
                    bancostraba.push(this.bancotrabajadores)
                    formData.append('datos',JSON.stringify(bancostraba))
                    break;
                default:

            }


            axios.post('/solicitude-trabajador-store',formData,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((res)=>{
                this.respuesta = true
                this.alerta= 'alert-success'
                this.mensajes = 'Solicitud enviada exitosamente .Con un plazo de 48 hrs como maximo su solicitud sera respondida'

                this.asunto =''
                this.retiro =''
                this.mensaje = ''
                this.tipo_solicitud=''
                this.uso_certificado=''
                this.otro_uso = ''
                this.tipo_datos_a_cambiar = ''
                this.direccion = ''
                this.comuna = ''
                this.region = ''
                this.documento_direccion = ''

            }).catch( (error) => {
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al enviar el formulario'
                this.errorsClass = 'form-control is-invalid';
                if (error.response.status === 422) {
                    this.mostarError = true
                    this.errors = error.response.data.errors || {};
                }
            })
        },
        cargarState:function(){
            axios.get('/regiones').then(res=>{
                this.regiones = res.data
            })
        },
        cargarCities:function(){
            let id = this.region

            axios.get('/comunas').then(res=>{
                //this.formulario.comuda_id = '0'
                this.comunas = res.data
                this.arrayComunas = res.data
            })
        },
        cargarCitiesFiltro:function (){
            let id = this.region
            console.log(id)
            //this.cargarCities()
            this.comunas = this.arrayComunas.filter((item) => item.region_id === this.region)
        },
        cambioDeSolicitud:function (){
            switch(this.tipo_solicitud) {
                case 'copia de contrato':
                    this.esCertificadoAntiguidad=false
                    this.esContrato = true
                    this.esCambioBanco = false
                    this.esCambioDatos = false
                    this.esCargaFamiliar = false
                    this.esdireccion = false
                    this.estelefono = false
                    break;
                case 'certificado antiguidad':

                    this.esCertificadoAntiguidad=true
                    this.esContrato = false
                    this.esCambioBanco = false
                    this.esCambioDatos = false
                    this.esCargaFamiliar = false
                    this.esdireccion = false
                    this.estelefono = false
                    break;
                case 'carga familiar':
                    this.esCertificadoAntiguidad=false
                    this.esContrato = false
                    this.esCambioBanco = false
                    this.esCambioDatos = false
                    this.esCargaFamiliar = true
                    this.esdireccion = false
                    this.estelefono = false
                    break;
                case 'modificacion de datos':
                    this.esCertificadoAntiguidad=false
                    this.esContrato = false
                    this.esCambioBanco = false
                    this.esCambioDatos = true
                    this.esCargaFamiliar = false
                    this.esdireccion = false
                    this.estelefono = false
                    break;
                case "cambio cuenta bancaria":
                    this.esCertificadoAntiguidad=false
                    this.esContrato = false
                    this.esCambioBanco = true
                    this.esCambioDatos = false
                    this.esCargaFamiliar = false
                    this.esdireccion = false
                    this.estelefono = false
                    break;
                default:
                    this.esCertificadoAntiguidad=false
                    this.esContrato = false
                    this.esCambioBanco = false
                    this.esCambioDatos = false
                    this.esCargaFamiliar = false
                    this.esdireccion = false
                    this.estelefono = false
            }
        },
        cambiar_uso_certificado:function (){
           let uso_certificado = this.uso_certificado
            if (uso_certificado === 'otro'){
                this.otro_uso_certificado = true
            }
            else{
                this.otro_uso_certificado = false
            }
        },
        cambiodatos:function (){
            let tipos_datos_a_cambiar = this.tipo_datos_a_cambiar
            switch (tipos_datos_a_cambiar){
                case "direccion":
                    this.esdireccion = true
                    this.estelefono = false
                    this.cargarState()
                    this.cargarCities()
                    break;
                case "telefono":
                    this.esdireccion = false
                    this.estelefono = true
                break
            }
        },
        onFileChangeResidencia() {
            //console.log(e.target.files[0]);
            //this.filename =   this.$certificado.file.files[0].name;
           // this.size =  this.file = this.$certificado.file.files[0].size;
            this.documento_direccion = this.$refs.certificado.files[0];
        },
        onFileChangeCertifacadoNac() {
            //console.log(e.target.files[0]);
            this.filename =   this.$refs.certificado_nac.files[0].name;
            this.size =  this.file = this.$refs.certificado_nac.files[0].size;
            this.certificado_nacimientos = this.$refs.certificado_nac.files;
        }

    },
}
</script>

<style scoped>

</style>
