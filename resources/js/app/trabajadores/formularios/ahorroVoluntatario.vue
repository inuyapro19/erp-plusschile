<template>
    <div class="col-lg-11 mx-auto">

        <div class="row">
            <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                <div :class="'alert '+alert_success" v-show="success">Banco agregado exitosamente</div>
                <div :class="'alert '+alert_danger" v-show="danger">Debe rellenar todos los campos</div>
                <div class="form">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Tipo Ahorro</label>
                            <select :class="$v.ahorro.tipo_ahorro.$error ? 'form-control is-invalid':'form-control'" v-model="$v.ahorro.$model.tipo_ahorro" :disabled="editarTrabajador">
                                <option value="0">Selecciones Tipo Ahorro</option>
                                <option value="APV REGIMEN A">APV REGIMEN A</option>
                                <option value="APV REGIMEN B">APV REGIMEN B</option>
                                <option value="APV REGIMEN C">APV REGIMEN C</option>
                                <option value="CUENTA 2">CUENTA 2</option>
                            </select>
                            <div v-show="$v.ahorro.tipo_ahorro.$error" class="invalid-feedback">El Tipo de Ahorro es Requerido</div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Entidad</label>
                            <select :class="$v.ahorro.ahorro_voluntario_id.$error ? 'form-control is-invalid':'form-control'" v-model="$v.ahorro.$model.ahorro_voluntario_id" :disabled="editarTrabajador" >
                                <option value="0">Selecciones Entidad</option>
                                <option v-for="(entidad, index) in entidad_voluntario" :value="entidad.id">{{entidad.nombre}}</option>
                            </select>
                            <div v-show="$v.ahorro.ahorro_voluntario_id.$error" class="invalid-feedback">La entidad es Requerido</div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Tipo Moneda (UF,%,$)</label>
                            <select :class="$v.ahorro.tipo_moneda.$error ? 'form-control is-invalid':'form-control'" v-model="$v.ahorro.$model.tipo_moneda" :disabled="editarTrabajador" >
                                <option value="">Selecciones Monto</option>
                                <option value="PESO">PESO</option>
                                <option value="UF">UF</option>
                                <option value="PORCENTAJE">PORCENTAJE</option>
                            </select>
                            <div v-show="$v.ahorro.tipo_moneda.$error" class="invalid-feedback">El tipo de moneda es Requerido</div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Monto</label>
                            <input type="number" :class="$v.ahorro.monto.$error ? 'form-control is-invalid':'form-control'" v-model="$v.ahorro.$model.monto" :disabled="editarTrabajador">
                            <div v-show="$v.ahorro.monto.$error" class="invalid-feedback">El tipo de moneda es Requerido</div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Forma de Pago</label>
                            <select :class="$v.ahorro.forma_pago.$error ? 'form-control is-invalid':'form-control'" v-model="$v.ahorro.$model.forma_pago" :disabled="editarTrabajador">
                                <option value="">Selecciones Monto</option>
                                <option value="DIRECTO">DIRECTO</option>
                                <option value="INDIRECTO">INDIRECTO</option>
                            </select>
                            <div v-show="$v.ahorro.forma_pago.$error" class="invalid-feedback">El tipo de moneda es Requerido</div>
                        </div>
                        <div class="col-md-6" >
                            <div class="form-group">
                                <label for="fecha_ingreso">Fecha ingreso</label>
                                <input type="date" v-model="$v.ahorro.$model.fecha_ingreso" :class="$v.ahorro.fecha_ingreso.$error ? 'form-control is-invalid':'form-control'" id="fecha_ingreso" :disabled="editarTrabajador">
                            </div>
                            <div v-show="$v.ahorro.fecha_ingreso.$error" class="invalid-feedback">La Fecha de ingreso es Requerido</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="tiene_fecha_vencimiento">Posee fecha vencimiento</label>
                        </div>
                        <div class="col-md-2">

                            <label class="switch s-icons s-outline s-outline-success mr-2">
                                <input type="checkbox" id="tiene_fecha_vencimiento" v-model="tiene_fecha_vencimiento" checked :disabled="editarTrabajador">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="col-md-5" v-show="tiene_fecha_vencimiento">
                            <div class="form-group">
                                <label for="fecha_termino_carga">Fecha vencimiento</label>
                                <input type="date" v-model="ahorro.fecha_vencimiento" class="form-control  form-control-sm" id="fecha_termino_carga" :disabled="editarTrabajador">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" v-show="mostraragregarContacto">
                            <button type="button" class="btn btn-secondary btn-sm" @click.prevent="agregarAhorro" :disabled="editarTrabajador"> <i class="fa fa-plus"></i> Agregar</button>
                        </div>
                        <div class="col-md-12" v-show="mostareditarContacto">
                            <button type="button" class="btn btn-secondary btn-sm" @click.prevent="EditarAhorro" :disabled="editarTrabajador"> <i class="fa fa-plus"></i> Editar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <th>Tipo Ahorro</th>
                    <th>Entidad</th>
                    <th>Moneda</th>
                    <th>Monto</th>
                    <th>Forma Pago</th>
                    <th>Acciones</th>
                    </thead>
                    <tbody>
                        <tr v-for="(ahorro, index) in ahorros">
                            <td>{{ahorro.tipo_ahorro}}</td>
                            <td>{{ahorro.ahorro_voluntario_id}}</td>
                            <td>{{ahorro.tipo_moneda}}</td>
                            <th>{{ahorro.monto}}</th>
                            <th>{{ahorro.forma_pago}}</th>
                            <td>
                                <button type="button" @click="deleteAhorro(ahorro.id)" class="btn btn-danger btn-sm"title="eliminar"><i class="fa fa-trash"></i></button>
                                <button type="button" @click="obtenerAhorro(ahorro.id)" class="btn btn-info btn-sm" title="editar"><i class="fa fa-edit"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapState} from "vuex";
import {email, required} from "vuelidate/lib/validators";
const shortid = require('shortid');
export default {
    props:{
        editarTrabajador:Boolean
    },
    computed:{
        ...mapState('Ahorro',['ahorro','ahorros','mostraragregarContacto','mostareditarContacto'])
    },
    data() {
        return {
            boton_color:'btn btn-sm btn-default',
            alert_success:'alert-success',
            alert_danger:'alert-danger',
            success:false,
            danger:false,
            entidad_voluntario:[],
            tiene_fecha_vencimiento:false
        }
    },
    validations: {
        ahorro: {
            tipo_ahorro:{required},
            ahorro_voluntario_id:{required},
            tipo_moneda:{required},
            monto:{required},
            forma_pago:{required},
            fecha_ingreso:{required}
        }
    },
    mounted() {
        this.cargar_entidad_voluntarios()
    },
    methods:{
        ...mapActions('Ahorro',['addAhorro','generateID','deleteAhorro','obtenerAhorro','updateAhorro']),
        cargar_entidad_voluntarios:function (){
            axios.get('/ahorro-voluntario').then(res=>{
                this.entidad_voluntario = res.data
            })
        },
        agregarAhorro:function (){
            this.$v.$touch()
            if (this.$v.$invalid) {
                this.danger = true
                console.log('error en el envio de formulario')
               // console.log(this.$v.contactoForm.nombre.required)
            }else {
                //$v.ahorro.tipo_ahorro.$error = false
                this.success = true
                this.danger = false
                let id = shortid.generate()
                this.generateID(id)
                this.addAhorro()
                let entidad_voluntaria = this.entidad_voluntario.find(item => item.id === this.ahorro.ahorro_voluntario_id)

            }
        },
        EditarAhorro:function (){
            this.$v.$touch()
            if (this.$v.$invalid) {
                this.danger = true
                console.log('error en el envio de formulario')
                // console.log(this.$v.contactoForm.nombre.required)
            }else {
                //$v.ahorro.tipo_ahorro.$error = false
                this.success = true
                this.danger = false
                //let id = shortid.generate()
                //this.generateID(id)
                this.updateAhorro(this.ahorro)
                //let entidad_voluntaria = this.entidad_voluntario.find(item => item.id === this.ahorro.ahorro_voluntario_id)

            }
        }
    }
}
</script>

<style scoped>

</style>
