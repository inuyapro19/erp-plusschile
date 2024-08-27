<template>
    <CardComponent :title="'Crear Licencia Medica'">

        <template #body>
            <!--  <div class="col-md-6 form-group">
          <button type="button" class="btn btn-success btn-sm" @click.prevent="filtrarListaTrabajador()">Buscar</button>
       </div>-->
            <form  @submit.prevent="enviarFormulario">
                <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <!--- <input type="text" v-model="rut" id="rut" class="form-control" placeholder="Ingrese rut sin puntos y con guión">-->
                        <label for="trabajador_id">Nombre Trabajador</label>
                        <select-2
                            v-model="trabajador_id"
                            dataType="number"
                            @select-changed="filtrarListaTrabajador()"
                        >
                            <option value="">--------</option>
                            <option v-for="(trabajador, index) in trabajadores"  :value="trabajador.id">{{trabajador.rut+' - '+trabajador.primer_nombre +' '+ trabajador.primer_apellido+ ' ' +trabajador.segundo_apellido}}</option>
                        </select-2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="nombre">RUT</label>
                        <input type="text" v-model="rut" id="rut" class="form-control" :disabled="true">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" v-model="nombre_trabajador" id="nombre" class="form-control" :disabled="true">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="cargo">Cargo</label>
                        <input type="text" v-model="cargo_trabajador" id="cargo" class="form-control" :disabled="true">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="ubicacion">Ubicación</label>
                        <input type="text" v-model="ubicacion_trabajador" id="ubicacion" class="form-control" :disabled="true">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="empleador">Empleador</label>
                        <input type="text" v-model="nombre_empleador" id="empleador" class="form-control" :disabled="true">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="fecha_emision">Fecha Emisión</label>
                        <date-picker v-model="fecha_emision" id="fecha_emision" valueType="format" />
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="fecha_recepcion">Fecha Recepción</label>
                        <date-picker  v-model="fecha_recepcion" id="fecha_recepcion" valueType="format" />
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="fecha_procesado">Fecha Procesado</label>
                        <date-picker  v-model="fecha_procesado" id="fecha_procesado" valueType="format" />
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="fecha_inicio">Fecha Inicio</label>
                        <date-picker  v-model="fecha_inicio" id="fecha_inicio" valueType="format"   />
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="dias">Días</label>
                        <div class="input-group mb-3">
                            <input type="number" v-model="dias" id="dias" min="1" class="form-control" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                            <button class="btn btn-success" @click="calcular_fecha_termino()" type="button" id="button-addon1">Calcular</button>
                        </div>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="fecha_inicio">Fecha Fin</label>
                        <date-picker  v-model="fecha_fin" id="fecha_inicio" valueType="format"  :disabled="true"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="">Tipo de licencia medica</label>
                        <select name="" v-model="tipo_licencia" class="form-select">
                            <option v-for="(tipo_licencia,  index) in tipo_licencias" :value="tipo_licencia.value">{{tipo_licencia.descripcion}}</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="medio">Medio</label>
                        <select  v-model="medio" id="medio" class="form-select" >
                            <option value="">---------</option>
                            <option v-for="medio in medios" :value="medio">{{medio}}</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="motivo">Motivo</label>
                        <input type="text" v-model="motivo" id="motivo" class="form-control" >
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <a href="/licencias-medicas" class="btn btn-default btn-sm">Volver</a>
                        <button type="submit" class="btn btn-primary btn-sm" :disabled="activar_boton">Guardar</button>
                    </div>
                </div>

            </form>
        </template>

    </CardComponent>
</template>

<script>
import 'vue2-datepicker/index.css';
import moment from "moment/moment";
import CardComponent from "@/components/CardComponent.vue";
import Select2 from "@/components/Form/Select2.vue";
export default {
    components: {
        CardComponent,
        Select2
    },
    data() {
        return {
            tipo_licencia:'',
            fecha_emision:'' ,
            fecha_inicio:'',
            fecha_recepcion:'',
            fecha_procesado:'',
            fecha_fin:'',
            medio:'',
            medios:['mutualidad', 'imed', 'medipass' ,'física'],
            motivo:'',
            trabajador_id:'',
            estado:'',
            licencias:[],
            trabajadores:[],
            trabajador_selecionado:[],
            nombre_trabajador:'',
            cargo_trabajador:'',
            nombre_empleador:'',
            ubicacion_trabajador:'',
            rut:'',
            dias:0,
            activar_boton:true,
            licencia_indefinida:false,
            tipo_licencias:[
                {
                    value:1,
                    descripcion:'ENFERMEDAD O ACCIDENTE COMÚN'
                },
                {
                    value:2,
                    descripcion:'PRORROGA MEDICINA PREVENTIVA'
                },
                {
                    value:3,
                    descripcion:'LICENCIA MATERNAL PRE Y POST NATAL'
                },
                {
                    value:4,
                    descripcion:'ENFERMEDAD GRAVE NIÑO MENOR DE 1 AÑO'
                },
                {
                    value:5,
                    descripcion:'ACCIDENTE DEL TRABAJO O DEL TRAYECTO'
                },
                {
                    value:6,
                    descripcion:'ENFERMEDAD PROFESIONAL'
                },
                {
                    value:7,
                    descripcion:'PATOLOGIA DEL EMBARAZO'
                },
            ],
            mostrar_formulario:false,
            //mensaje de respuesta e errores
            mensaje:'',
            respuesta:false,
            alerta:'',
            mensajes:'',
            errors:[],
            inputClass:'form-control mb-4',
            errorsClass:'',
        }
    },
    mounted() {
        this.getTrabajadores()
    },
    updated() {
        this.refrescar()
    },
    methods: {
        refrescar:function(){
            //this.$refs.categorias.selectpicker('refresh')
            $(this.$refs.trabajadores).selectpicker('refresh')
           // $(this.$refs.buses).selectpicker('refresh')
        },
        async getTrabajadores (){
            try {

                const {data , status} = await axios.get('/lista-trabajadores')

                if (status === 200){
                    this.trabajadores = data
                }

            }catch (error) {
                console.log(error)
            }

        },
        filtrarListaTrabajador:function (){
          //primero un buscar al trabajador por el rut
           //segundo se despliega el formulario de ingreso de la licencia
           // let rut = this.rut
            if(this.trabajador_id !== 0){
                this.trabajador_selecionado = this.trabajadores.find(item => item.id === this.trabajador_id)
                this.nombre_trabajador = this.trabajador_selecionado.primer_nombre + ' ' + this.trabajador_selecionado.primer_apellido
                this.rut = this.trabajador_selecionado.rut
                this.cargo_trabajador = this.trabajador_selecionado.contrato.cargo.nombre_cargo
                this.nombre_empleador = this.trabajador_selecionado.contrato.empleador.nombre_empleador
                this.ubicacion_trabajador = this.trabajador_selecionado.contrato.ubicacion.nombre_ubicacion

              /* console.log(this.trabajador_selecionado.primer_nombre)
                console.log(this.trabajador_selecionado.contrato.empleador.nombre_empleador)
                console.log(this.trabajador_selecionado.contrato.cargo.nombre_cargo)
                console.log(this.trabajador_selecionado.contrato.ubicacion.nombre_ubicacion)*/
                // console.log(this.trabajador_selecionado)
                //console.log( Object.keys(this.trabajador_selecionado).length)

             /*   if (!(this.trabajador_selecionado === undefined)){
                    this.trabajador_id = this.trabajador_selecionado.id
                    this.mostrar_formulario = true
                }
                else {
                    this.$swal('RUT NO ENCONTRADO');
                    this.mostrar_formulario = false
                }*/

            }else{
                //this.$swal('DEBE INGRESAR UN RUT');
                this.$swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'DEBE INGRESAR UN RUT',
                })
            }
        },
        getTipolicencia:function (){
          axios.get('/tipo-licencia-medicas').then((res)=>{
              this.tipo_licencias = res.data
          }).catch((error)=>{
                console.log(error)
          })
        },
       async enviarFormulario(){
            try{
                let formData = new FormData

                formData.append('fecha_emision',this.fecha_emision)
                formData.append('fecha_inicio',this.fecha_inicio)
                formData.append('fecha_termino',this.fecha_fin)
                formData.append('fecha_recepcion',this.fecha_recepcion)
                formData.append('fecha_procesado',this.fecha_procesado)

                formData.append('medio',this.medio)
                formData.append('dias',this.dias)
                formData.append('motivo',this.motivo)
                formData.append('trabajador_id',this.trabajador_id)
                formData.append('tipo_licencia',this.tipo_licencia)

                const {status} = await axios.post('/licencias-medicas',formData)

                if (status === 200){
                    this.respuesta = true
                    this.alerta = 'alert-success'

                    this.$swal.fire({
                        title: 'Licencia creado exitosamente',
                        text: "¿Desea ingresar otra Licencia medica?",
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.value) {
                            this.limpiarFormulario()
                        }else{
                            window.location.href = "/licencias-medicas";
                        }
                    })
                }

            }catch (error) {
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al enviar el formulario'
                this.errorsClass = 'form-control is-invalid';

                this.$swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error al enviar el formulario',
                })
            }
        },
        limpiarFormulario(){
            this.trabajador_id = 0
            this.rut = ''
            this.nombre_trabajador = ''
            this.cargo_trabajador = ''
            this.nombre_empleador = ''
            this.ubicacion_trabajador = ''
            this.fecha_emision = ''
            this.fecha_inicio = ''
            this.fecha_fin = ''
            this.fecha_recepcion = ''
            this.fecha_procesado = ''
            this.medio = ''
            this.dias = ''
            this.motivo = ''
            this.tipo_licencia = 0
            this.respuesta = false
            this.alerta = ''
            this.mensajes = ''
            this.errorsClass = 'form-control';
            this.activar_boton = true
        },
        calcular_fecha_termino(){
            let fecha_inicio
            let dias
            let fecha_final

            /*VALIDAR FECHA DE INICIO*/
            if (this.fecha_inicio !== ''){
                fecha_inicio = new Date(this.fecha_inicio)
                console.log(fecha_inicio)
            }else{
                this.$swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'DEBE INGRESAR UNA FECHA DE INICIO',
                })
                return false
            }

            /*VALIDAR FECHA DE INICIO*/
            if (this.dias !== 0){
                dias = parseInt(this.dias)
            }else{
                this.$swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'DEBE INGRESAR UNA CANTIDAD DE DIAS',
                })
            }
            //SUMA DE FECGA DE INICIO + DIAS
            this.fecha_fin =  moment(fecha_inicio).add(dias,'days').format('YYYY-MM-DD')
            console.log(this.fecha_fin)
            this.activar_boton = false
        }
    },
}
</script>

<style scoped>
.mx-datepicker {
    position: relative;
    display: block!important;
    width: 100% !important;
}
.mx-input {
    display: inline-block;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    width: 100%;
    height: calc(1.4em + 1.4rem + 2px)!important;
    padding: 6px 30px;
    padding-left: 10px;
    font-size: 14px;
    line-height: 1.4;
    color: #555;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
    box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
}

</style>
