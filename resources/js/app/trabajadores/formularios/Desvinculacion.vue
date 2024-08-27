<template>
    <div>
        <button class="btn btn-danger btn-sm" @click="abrirModal" type="button"> <i class="fa fa-trash"></i> Desvicular</button>


        <div class="modal fade" id="desvinculacion" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" id="standardModalLabel">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Desviculacion</h5>
                        <button type="button" class="close" @click="cerrarModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

<!--                        <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>-->
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="fecha_desvinculacion">Fecha de Desvinculación</label>
<!--                                <input type="date" v-model="fecha_desvinculacion" class="form-control" id="fecha_desvinculacion">-->
                                <date-picker v-model="fecha_desvinculacion" valueType="format" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="causal_de_hecho">Causal de Hecho</label>
                                <textarea v-model="causal_de_hecho" class="form-control" id="causal_de_hecho" cols="10" rows="10"></textarea>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="motivo_interno_empresa">Motivo Interno Empresa</label>
                                <textarea v-model="motivo_interno_empresa" class="form-control" id="motivo_interno_empresa" cols="10" rows="10"></textarea>

                            </div>
                            <div class="col-md-8 form-group">
                                <label for="derecho">Motivos</label>
                                <select name="" id="derecho" v-model="derecho" class="form-control">
                                    <option value="">-----------</option>
                                    <option v-for="(motivo, index) in motivos" :value="motivo.id">{{motivo.descripcion}}</option>
                                </select>
                            </div>
                        </div>

                    <div class="modal-footer">
                            <button class="btn btn-default btn-sm" @click="cerrarModal">Cerrar</button>
                            <button class="btn btn-primary btn-sm" @click.prevent="desvinculacion()">Confirmar</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    </div>

</template>

<script>
export default {
    props:{
        id:{
            type:Number,
            required:false,
            default: 0
        }
    },
    data() {
        return {
            fecha_desvinculacion: '',
            causal_de_hecho:'',
            motivo_interno_empresa:'',
            derecho:'',
            bloqueo:false,
            derechos_select:[],
            mensaje:'',
            respuesta:false,
            alerta:'',
            mensajes:'',
            errors:[],
            inputClass:'form-control mb-4',
            errorsClass:'',
            motivos:[]
        }
    },
    mounted() {
     this.getMotivos()
    },
    methods:{
        async desvinculacion(){
            try {
                let id = this.id

                //validacion
                this.validaciones()
                //confirmar si desea desvincular swal alert confirm y respuesta true
                let respuesta = await this.$swal({
                    title: '¿Estas seguro de desvincular este trabajador?',
                    text: "Sus datos pasaran a la tabla de trabajadores desvinculados",
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                if (respuesta) {

                    //formdata
                    let formData = new FormData()
                    formData.append('fecha_desvinculacion',this.fecha_desvinculacion)
                    formData.append('causal_de_hecho',this.causal_de_hecho)
                    formData.append('motivo_interno_empresa',this.motivo_interno_empresa)
                    formData.append('derecho',this.derecho)


                    let url = '/trabajadores-desvinculador/'+id
                    let {status} = await axios.post(url, formData)
                    if (status === 200) {
                        this.$swal({
                            title: 'Desvinculado',
                            text: 'El trabajador ha sido desvinculado',
                            icon: 'success',
                            button: 'Aceptar',
                        })
                        this.cerrarModal()
                        //this.$emit('desvinculado')
                        //redireccionar a trabajadores
                        window.location.href = '/trabajadores'
                    }
                }
            }catch (error) {
                // this.respuesta = true
                // this.alerta= 'alert-danger'
                // this.mensajes = 'Error al enviar el formulario'
                // this.errorsClass = 'form-control is-invalid';
                //swal alert error
                this.$swal.fire({
                    title: 'Error al enviar el formulario',
                    icon: 'error',
                    showConfirmButton: true
                })

            }
        },
        abrirModal(){
            $('#desvinculacion').modal('show')
        },
        cerrarModal(){
            $('#desvinculacion').modal('hide')
        },
       async getMotivos(){
           try {

             const {data , status}  = await axios.get('/motivos')

             if (status === 200) {
                 this.motivos = data
             }
           }catch (error) {

           }
        },
        validaciones(){
            if(this.fecha_desvinculacion == ''){
                this.$swal.fire({
                    title: 'Error!',
                    text: 'La fecha de desvinculación es requerida',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                })
                return false
            }

            if(this.causal_de_hecho == ''){
                this.$swal.fire({
                    title: 'Error!',
                    text: 'La causal de hecho es requerida',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                })
                return false
            }
            if(this.motivo_interno_empresa == ''){
                this.$swal.fire({
                    title: 'Error!',
                    text: 'El motivo interno de la empresa es requerido',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                })
                return false
            }
            if(this.derecho == ''){
                this.$swal.fire({
                    title: 'Error!',
                    text: 'El motivo es requerido',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                })
                return false
            }
            return true
        }
    }
}
</script>

<style scoped>
label{
    color:#222222;
    font-size:15px;
}
textarea{
    height:100px
}
</style>
