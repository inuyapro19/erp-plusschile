<template>
    <div>
        <form @submit.prevent="enviar_formulario()">
            <div class="account-content ">
                <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                    <div class="row">
                        <div class="col-md-12">
                            <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing section general-info">



                            <div class="info">
                                <h6 class="">Información personal <button class="btn btn-success btn-sm">Guardar</button></h6>


                                <div class="alert alert-info">
                                    Si alguno de sus datos se encuentran erróneo debe informar al Departamento de Recursos Humanos de su empleador
                                </div>

                                <div class="row">
                                    <PerfilComponent ></PerfilComponent>

                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="n-chk">
                                            <label class="new-control new-checkbox checkbox-primary">
                                                <input type="checkbox" v-model="terminos" class="new-control-input mb-4">
                                                <span class="new-control-indicator"></span>Acepto y solicito recibir información que mi empleador me desee proporcionar vía correo electrónico o teléfono celular.
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">

                                    </div>
                                </div>
                            </div>

                        </div>

                        <ContactoEmergenciaComponent :rut="rut"></ContactoEmergenciaComponent>

                        <div class="col-xl-12 col-lg-12 col-md-12 mt-4 pl-5 pr-5 layout-spacing section contact">

                            <div class="info">
                                <h5 class="">Datos Contra Actuales</h5>
                                <div class="row">
                                    <ContratoComponent></ContratoComponent>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>


        </form>

    </div>

</template>

<script>
import PerfilComponent from "./PerfilComponent";
import ContactoEmergenciaComponent from "./ContactoEmergenciaComponent";
import ContratoComponent from "./ContratoComponent";
import {mapActions, mapState} from "vuex";

export default {
    props: {
        rut:String
    },
    components:{
        PerfilComponent,
        ContactoEmergenciaComponent,
        ContratoComponent
    },
    computed:{
      ...mapState('contacto',['perfilContacto']),
        ...mapState('trabajador',['trabajador'])
    },
    data() {
        return {
            id:0,
            perfil:[],
            contacto1: [],
           // contacto2:[],
            contrato:[],
            contrasena:'',
            confirmar_contrasena:'',
            mensaje:'',
            respuesta:false,
            alerta:'',
            mensajes:'',
            errors:[],
            terminos:false,
            inputClass:'form-control mb-4',
            errorsClass:'',
        }
    },
    created () {
        this.trabajador_perfil(this.rut)
    },
    mounted() {
        this.cargarPrimerContacto()
        this.cargarSegundoContacto()
        this.cargarContrato()

    },
    methods:{
        ...mapActions('trabajador',['trabajador_perfil']),
      /*  cargarTrabajador:function (){
            let rut = this.rut
            axios.get('/getPerfil/'+rut).then((res)=>{
                this.perfil = res.data
                this.id = this.perfil.id
            }).catch((error)=>{
                console.log(error)
            })
        },*/
        cargarPrimerContacto:function (){

            axios.get('/getPerfilPrimerContacto').then((res)=>{
                this.contacto1 = res.data
            }).catch((error)=>{
                console.log(error)
            })
        },
        cargarSegundoContacto:function (){
            let id = this.id

            axios.get('/getPerfilSegundoContacto').then((res)=>{
                this.contacto2 = res.data
            }).catch((error)=>{
                console.log(error)
            })
        },
        cargarContrato:function (){
            axios.get('/getPerfilContrato').then((res)=>{
                this.contrato = res.data
            }).catch((error)=>{
                console.log(error)
            })
        },
        enviar_formulario:function (){
            let formData = new FormData
            let rut = this.perfil.rut


            formData.append('telefono_celular',this.trabajador.telefono_celular)
            formData.append('telefono_local',this.trabajador.telefono_local)
            formData.append('correo',this.trabajador.correo)
           formData.append( 'datos_personales',1)
            //Contacto 1 y dos
           /* let contactos = []
            contactos.push(this.perfilContacto)
            formData.append('contacto',JSON.stringify(contactos))*/


            if (this.terminos){
                axios.post('/perfil/'+rut,formData).then(res=>{
                    this.respuesta = true
                    this.alerta = 'alert-success'
                    this.mensajes = 'Perfil editado exitosamente'
                }).catch( error =>{
                    this.respuesta = true
                    this.alerta= 'alert-danger'
                    this.mensajes = 'Error al enviar el formulario'
                    this.errorsClass = 'form-control is-invalid';
                })
            }else{
                this.$swal('Debe aceptar los términos')
            }
        }
    }
}
</script>

<style scoped>

</style>
