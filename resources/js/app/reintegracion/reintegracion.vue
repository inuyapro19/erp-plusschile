<template>
    <div class="col-md-11 mx-auto">
        <form @submit.prevent="reintegracion">
            <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="empleador_id">Empleador</label>
                        <select name="empleador_id" v-model="contrato.empleador_id" :class="errors.empleador_id !== undefined ? errorsClass : inputClass" id="empleador_id" >
                            <option value="">----------</option>
                            <option v-for="(empleadores, index) in empleador" :value="empleadores.id">{{empleadores.nombre_empleador}}</option>
                        </select>
                        <div v-if="errors.empleador_id">
                            <div class="invalid-feedback" style="display: block" v-for="(mensaje_empleado , index) in errors.empleador_id"  :disabled="editarTrabajador" >{{mensaje_empleado}}</div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="ubicacion_id">Ubicación</label>
                        <select name="ubicacion_id" v-model="contrato.ubicacion_id" :class="errors.ubicacion_id !== undefined ? errorsClass : inputClass" id="ubicacion_id" >
                            <option value="">----------</option>
                            <option v-for="(ubicaciones, index) in ubicacion" :value="ubicaciones.id">{{ubicaciones.nombre_ubicacion}}</option>
                        </select>
                        <div v-if="errors.ubicacion_id">
                            <div class="invalid-feedback" style="display: block" v-for="(mensaje_ubicacion , index) in errors.ubicacion_id" >{{mensaje_ubicacion}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="area_id">Area</label>
                        <select name="area_id" v-model="contrato.area_id" :class="errors.area_id !== undefined ? errorsClass : inputClass" id="area_id"  >
                            <option value="">----------</option>
                            <option v-for="(area, index) in areas" :value="area.id">{{area.descripcion_area}}</option>
                        </select>
                        <div v-if="errors.area_id">
                            <div class="invalid-feedback" style="display: block" v-for="(mensaje_area , index) in errors.area_id" >{{mensaje_area}}</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="cargo_id">Cargo</label>
                        <select name="cargo_id" v-model="contrato.cargo_id" :class="errors.cargo_id !== undefined ? errorsClass : inputClass" ref="cargo_id" data-live-search="true" id="cargo_id"  >
                            <option value="">----------</option>
                            <option v-for="(cargo, index) in cargos" :value="cargo.id">{{cargo.nombre_cargo}}</option>
                        </select>
                        <div v-if="errors.cargo_id">
                            <div class="invalid-feedback" style="display: block" v-for="(mensaje_cargo, index) in errors.cargo_id" >{{mensaje_cargo}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-success btn-sm">Reintegrar</button>
            <a href="/desvinculados" class="btn btn-default btn-sm">Volver</a>
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
            contrato:{
                empleador_id:'',
                ubicacion_id:'',
                area_id:'',
                cargo_id:''
            },
            empleador:[],
            ubicacion:[],
            areas:[],
            cargos:[],
            respuesta:false,
            alerta:'',
            mensajes:'',
            errors:[],
            inputClass:'form-control mb-4',
            errorsClass:''
        }
    },
    mounted() {
        this.cargarAreas()
        this.cargarEmpleador()
        this.cargarUbicaciones()
        this.cargarCargos()
    },
    methods:{
        async cargarEmpleador(){
          await  axios.get('/empleador').then(res=>{
                this.empleador = res.data
            })
        },
       async cargarUbicaciones (){
          await  axios.get('/ubicaciones').then(res=>{
                this.ubicacion = res.data
            })
        },
      async cargarAreas (){
          await axios.get('/areas').then(res=>{
                this.areas = res.data
            })
        },
       async cargarCargos(){
         await axios.get('/cargos').then(res=>{
                this.cargos = res.data
            })
       },
       async reintegracion(){
            let id = this.id
            let formData = new FormData();
            /*Fomulario contratro*/
            formData.append('empleador_id',this.contrato.empleador_id)
            formData.append('ubicacion_id',this.contrato.ubicacion_id)
            formData.append('area_id',this.contrato.area_id)
            formData.append('cargo_id',this.contrato.cargo_id)

          await axios.post('/reincorporar/'+id,formData,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((res)=>{
                this.respuesta = true
                this.alerta= 'alert-success'
                this.mensajes = 'El trabajador ha sido reintegrado exitosamente'
                this.contrasena = ''
                this.confirm_contrasena=''
            }).catch( (error) => {
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al enviar el formulario'
                this.errorsClass = 'form-control is-invalid';
                if (error.response.status === 403) {
                    this.mostarError = true
                    this.errors = error.response.data.errors || {};
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
