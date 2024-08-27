<template>
    <div class="col-md-11 mx-auto">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="empleador_id">Empleador</label>
                    <select name="empleador_id" v-model="contrato.empleador_id" :class="errors.empleador_id !== undefined ? errorsClass : inputClass" id="empleador_id"  :disabled="editarTrabajador">
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
                    <select name="ubicacion_id" v-model="contrato.ubicacion_id" :class="errors.ubicacion_id !== undefined ? errorsClass : inputClass" id="ubicacion_id"  :disabled="editarTrabajador">
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
                <label class="fecha_ingreso">Fecha Ingreso</label>
                <input type="date" v-model="contrato.fecha_ingreso" :class="errors.fecha_ingreso !== undefined ? errorsClass : inputClass" name="fecha_ingreso"  :disabled="editarTrabajador">
                <div v-if="errors.fecha_ingreso">
                    <div class="invalid-feedback" style="display: block" v-for="(mensaje_fecha_ingreso , index) in errors.fecha_ingreso" >{{mensaje_fecha_ingreso}}</div>
                </div>
            </div>
            <div class="col-sm-6">
                <label class="fecha_ingreso">Fecha Antigüedad</label>
                <input type="date" v-model="contrato.fecha_antiguidad" :class="errors.fecha_antiguidad !== undefined ? errorsClass : inputClass" name="fecha_ingreso"  :disabled="editarTrabajador">
                <div v-if="errors.fecha_antiguidad">
                    <div class="invalid-feedback" style="display: block" v-for="(mensaje_fecha_ingreso , index) in errors.fecha_antiguidad" >{{mensaje_fecha_ingreso}}</div>
                </div>
            </div>
            <div class="col-sm-6">
                <label class="fecha_ingreso">Fecha Primer Vencimiento </label>
                <input type="date" v-model="contrato.fecha_vencimiento_contrato" :class="errors.fecha_vencimiento_contrato !== undefined ? errorsClass : inputClass" name="fecha_ingreso"  :disabled="editarTrabajador">
                <div v-if="errors.fecha_vencimiento_contrato">
                    <div class="invalid-feedback" style="display: block" v-for="(mensaje_fecha_ingreso , index) in errors.fecha_vencimiento_contrato" >{{mensaje_fecha_ingreso}}</div>
                </div>
            </div>
            <div class="col-sm-6">
                <label class="fecha_ingreso">Fecha Segundo Vencimiento</label>
                <input type="date" v-model="contrato.fecha_vencimiento_contrato_segundo" :class="errors.fecha_vencimiento_contrato_segundo !== undefined ? errorsClass : inputClass" name="fecha_ingreso"  :disabled="editarTrabajador">
                <div v-if="errors.fecha_vencimiento_contrato_segundo">
                    <div class="invalid-feedback" style="display: block" v-for="(mensaje_fecha_vencimiento_contrato_segundo , index) in errors.fecha_vencimiento_contrato_segundo" >{{mensaje_fecha_vencimiento_contrato_segundo}}</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="area_id">Area</label>
                    <select name="area_id" v-model="contrato.area_id" :class="errors.area_id !== undefined ? errorsClass : inputClass" id="area_id"  :disabled="editarTrabajador">
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
                    <select name="cargo_id" v-model="contrato.cargo_id" :class="errors.cargo_id !== undefined ? errorsClass : inputClass" ref="cargo_id" data-live-search="true" id="cargo_id"  :disabled="editarTrabajador">
                        <option value="">----------</option>
                        <option v-for="(cargo, index) in cargos" :value="cargo.id">{{cargo.nombre_cargo}}</option>
                    </select>
                    <div v-if="errors.cargo_id">
                        <div class="invalid-feedback" style="display: block" v-for="(mensaje_cargo, index) in errors.cargo_id" >{{mensaje_cargo}}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="centro_costo">Centro de costos</label>
                    <select name="centro_costo" v-model="contrato.centro_costo" :class="errors.centro_costo !== undefined ? errorsClass : inputClass" id="centro_costo"  :disabled="editarTrabajador">
                        <option value="">----------</option>
                        <option v-for="(costo, index) in centro_costo" :value="costo">{{costo}}</option>
                    </select>
                    <div v-if="errors.centro_costo">
                        <div class="invalid-feedback" style="display: block" v-for="(mensaje_centro, index) in errors.centro_costo" >{{mensaje_centro}}</div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="tipo_jornada">Tipos de Jornadas</label>
                    <select name="tipo_jornada" v-model="contrato.tipo_jornada" @click="isJornadaExcepcional" :class="errors.tipo_jornada !== undefined ? errorsClass : inputClass" id="tipo_jornada"  :disabled="editarTrabajador">
                        <option value="">----------</option>
                        <option v-for="(jornada, index) in tipo_jornada" :value="jornada">{{jornada}}</option>
                    </select>
                    <div v-if="errors.centro_costo">
                        <div class="invalid-feedback" style="display: block" v-for="(mensaje_centro, index) in errors.tipo_jornada" >{{mensaje_centro}}</div>
                    </div>
                </div>
            </div>
            <transition name="slide-fade">
            <div class="col-sm-6" v-show="esJornadaExcepcional">
                <div class="form-group">
                    <label for="jornada_excepcional">Jornada Excepcional</label>
                    <select name="jornada_excepcional" v-model="contrato.jornada_excepcional" :class="errors.jornada_excepcional !== undefined ? errorsClass : inputClass" id="jornada_excepcional"  :disabled="editarTrabajador">
                        <option value="">----------</option>
                        <option v-for="(jornada, index) in jornada_excepcional" :value="jornada">{{jornada}}</option>
                    </select>
                    <div v-if="errors.centro_costo">
                        <div class="invalid-feedback" style="display: block" v-for="(mensaje_centro, index) in errors.jornada_excepcional" >{{mensaje_centro}}</div>
                    </div>
                </div>
            </div>
            </transition>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="tipo_contrato">Tipo Contrato</label>
                    <select name="tipo_contrato" v-model="contrato.tipo_contrato"  :class="errors.tipo_contrato !== undefined ? errorsClass : inputClass" id="tipo_contrato"  :disabled="editarTrabajador">
                        <option value="">----------</option>
                        <option v-for="(tipo, index) in tipo_contrato" :value="tipo">{{tipo}}</option>
                    </select>
                    <div v-if="errors.centro_costo">
                        <div class="invalid-feedback" style="display: block" v-for="(mensaje_centro, index) in errors.tipo_contrato" >{{mensaje_centro}}</div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-5">
                <label for="tiene_licencia_conducir" class="form-check-label">Tiene Licencia Conducir</label>
            </div>
            <div class="col-md-3">

                <label class="switch s-icons s-outline s-outline-success  mr-2">
                    <input type="checkbox" id="tiene_licencia_conducir" v-model="licencia_conducir" :value="licencia_conducir"  :disabled="editarTrabajador"  @change.prevent="licencia()" checked>
                    <span class="slider"></span>
                </label>
            </div>
            <div class="col-md-4">

            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label class="fecha_ingreso">Sueldo Base</label>
                <input type="number" v-model="contrato.sueldo_base" :class="errors.sueldo_base !== undefined ? errorsClass : inputClass" name="sueldo_base"  :disabled="editarTrabajador">
                <div v-if="errors.sueldo_base">
                    <div class="invalid-feedback" style="display: block" v-for="(sueldo_base_mesaje , index) in errors.sueldo_base" >{{sueldo_base_mensaje}}</div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import Vuex from "vuex";
import {mapState,mapActions} from "vuex";
import { required,email} from 'vuelidate/lib/validators';

export default {
    props:{
        contrato:Object,
        errors: Array,
        inputClass:String,
        errorsClass:String,
        editarTrabajador:Boolean
    },
    computed:{
        ...mapState('trabajador',{
            licencia_conducir: state => state.licencia_conducir,
        }),
    },
    data() {
        return {
            empleador: [],
            ubicacion:[],
            areas:[],
            cargos:[],
            prevision:[],
            salud:[],
            centro_costo:[
                'Producción',
                'Administracón',
                'Ventas'
            ],
            tipo_contrato:[
                'Contrato a Plazo Fijo',
                'Contrato Indefinido',
                'Contrato por obra o faena',
                'Contrato por honorario',
                'Contrato practicante'
            ],
            tipo_jornada:[
                'Jornada completa',
                'Part Time',
                'Excepcional',
                'Turno Rotativo',
                'Bisemanal'
            ],
            jornada_excepcional:[
                '7x7','10x4','20x10'
            ],
            esFonasa:false,
            esJornadaExcepcional:false,
        }
    },

    mounted() {
        this.cargarEmpleador()
        this.cargarUbicaciones()
        this.cargarPrevicion()
        this.cargarAreas()
        this.cargarSalud()
        this.cargarCargos()
    },
    methods:{
        ...mapActions('trabajador',['licencia']),
       cargarEmpleador:function (){
           axios.get('/empleador').then(res=>{
               this.empleador = res.data
           })
       },
       cargarUbicaciones:function (){
           axios.get('/ubicaciones').then(res=>{
               this.ubicacion = res.data
           })
       },
       cargarAreas:function (){
           axios.get('/areas').then(res=>{
               this.areas = res.data
           })
       },
       cargarCargos:function (){

           axios.get('/cargos').then(res=>{
               this.cargos = res.data
           })
       },
       cargarPrevicion:function (){
           axios.get('/prevision').then(res=>{
               this.prevision = res.data
           })
       },
       cargarSalud:function (){
           axios.get('/salud').then(res=>{
               this.salud = res.data
           })
       },
        isFonosa:function (id){
            if(id==='fonosa'){
                this.esFonasa = !this.esFonasa
            }
            else{
                console.log('no es fonasa')
                this.esFonasa = !this.esFonasa
            }
        },
        isJornadaExcepcional:function (){
            if (this.contrato.tipo_jornada == 'Excepcional'){
                this.esJornadaExcepcional = true
            }
            else{
                this.esJornadaExcepcional = false
            }
        }
   }
}
</script>

<style scoped>

.slide-fade-enter-active {
    transition: all .3s ease;
}
.slide-fade-leave-active {
    transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to
    /* .slide-fade-leave-active below version 2.1.8 */ {
    transform: translateX(10px);
    opacity: 0;
}
</style>
