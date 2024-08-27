<template>
    <div class="col-md-11 mx-auto">
        <div class="alert alert-warning">* Puede agregar como maximo 2 contacto del trabajador</div>
        <div :class="'alert '+alert_success" v-show="success">Banco agregado exitosamente</div>
        <div :class="'alert '+alert_danger" v-show="danger">Debe rellenar todos los campos</div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="nombre1">Nombre</label>
                    <input type="text" v-model="$v.contactoForm.$model.nombre" :class="$v.contactoForm.nombre.$error ? 'form-control is-invalid':'form-control'" id="nombre1" :disabled="editarTrabajador">

                        <div v-show="$v.contactoForm.nombre.$error" class="invalid-feedback">El Nombre es Requerido</div>

                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="apellido1">Apellido</label>
                    <input type="text" v-model="$v.contactoForm.$model.apellido" :class="$v.contactoForm.apellido.$error ? 'form-control is-invalid':'form-control'" id="apellido1" :disabled="editarTrabajador">

                        <div v-show="$v.contactoForm.apellido.$error" class="invalid-feedback">El Apellido es Requerido</div>

                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="telefono1">Télefono</label>
                    <input type="text" v-model="$v.contactoForm.$model.telefono"  :class="$v.contactoForm.telefono.$error ? 'form-control is-invalid':'form-control'" id="telefono1" :disabled="editarTrabajador">

                        <div v-show="$v.contactoForm.telefono.$error" class="invalid-feedback">El Teléfono es Requerido</div>

                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="text" v-model="$v.contactoForm.$model.correo" id="correo" :class="$v.contactoForm.correo.$error ? 'form-control is-invalid':'form-control'" :disabled="editarTrabajador">

                        <div v-show="$v.contactoForm.correo.$error" class="invalid-feedback">El correo es Requerido</div>


                        <div v-show="$v.contactoForm.correo.email" class="invalid-feedback">Debe ser un correo valido</div>

                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="direccion1">Dirección</label>
                    <input type="text" v-model="$v.contactoForm.$model.direccion" id="direccion1" :class="$v.contactoForm.direccion.$error ? 'form-control is-invalid':'form-control'" :disabled="editarTrabajador">

                        <div  v-show="$v.contactoForm.direccion.$error" class="invalid-feedback">La dirección es Requerida</div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="contacto_region_id">Región</label>
                    <select v-model="$v.contactoForm.$model.region_id" :class="$v.contactoForm.region_id.$error ? 'form-control is-invalid':'form-control mb-4'" id="contacto_region_id" @change="cargarCitiesContacto()" :disabled="editarTrabajador">
                        <option value="0">Selecciones Región</option>
                        <option v-for="(region , index) in regiones" :value="region.id" >{{region.nombre_region}}</option>
                    </select>

                        <div  v-show="$v.contactoForm.region_id.$error" class="invalid-feedback">La Región es Requerida</div>

                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="contacto_comuna_id">comuna</label>
                    <select v-model="$v.contactoForm.$model.comuna_id" :class="$v.contactoForm.comuna_id.$error ? 'form-control is-invalid':'form-control mb-4'" id="contacto_comuna_id" :disabled="editarTrabajador">
                        <option value="0">Selecciones Comuna</option>
                        <option v-for="(comuna , index) in comunas" :value="comuna.id" >{{comuna.nombre_comuna}}</option>
                    </select>

                    <div v-show="$v.contactoForm.comuna_id.$error" class="invalid-feedback">La Región es Requerida</div>

                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="parentesco">Parentesco</label>
                    <select v-model="$v.contactoForm.$model.parentesco" :class="$v.contactoForm.parentesco.$error ? 'form-control is-invalid':'form-control mb-4'" id="parentesco" @change="OtroParentesco" :disabled="editarTrabajador">
                        <option value="0">Selecciones Parentesco</option>
                        <option v-for="(parentesco , index) in parentescos" :value="parentesco" >{{parentesco}}</option>
                    </select>

                    <div v-show="$v.contactoForm.parentesco.$error" class="invalid-feedback">El Parentesco es requerido</div>

                </div>
            </div>
            <div class="col-sm-6">
                <transition name="slide-fade">
                <div class="form-group" v-show="otro_parentesco">
                    <label for="otro_parentesco">Otro Parentesco</label>
                    <input type="text" class="form-control" v-model="contactoForm.otro_parentesco" id="otro_parentesco" placeholder="Ingrese otro parentesco" :disabled="editarTrabajador">

                </div>
                </transition>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12" v-show="mostraragregarContacto">
                <button class="btn btn-secondary btn-sm" @click.prevent="agregarContacto" :disabled="maximo" ><i class="fa fa-plus"></i> Agregar</button>
            </div>
            <div class="col-md-12" v-show="mostareditarContacto">
                <button class="btn btn-secondary btn-sm" @click.prevent="editarContacto"><i class="fa fa-plus"></i> Editar</button>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <table class="table table-striped table-hover" v-show="maximo_contacto > 0">
                    <thead>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Correo</th>
                        <th>Teléfeno</th>
                        <th>Dirección</th>
                        <th>Comuna</th>
                        <th>Región</th>
                         <th>Acciones</th>
                    </thead>
                    <tbody>
                        <tr v-for="(contactos, index) in contacto">
                            <td>{{contactos.nombre}}</td>
                            <td>{{contactos.apellido}}</td>
                            <td>{{contactos.correo}}</td>
                            <td>{{contactos.telefono}}</td>
                            <td>{{contactos.direccion}}</td>
                            <td>{{contactos.comuna_id ? contactos.comuna_id : contactos.comuna.nombre_comuna}}</td>
                            <td>{{contactos.region_id}}</td>
                            <td>
                                <button class="btn btn-danger btn-sm" @click.prevent="deleteContacto(contactos.id)" title="eliminar"><i class="fa fa-trash"></i></button>
                                <button class="btn btn-info btn-sm" @click.prevent="obtenerContacto(contactos.id)" title="editar"><i class="fa fa-edit"></i></button>
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
import {updateContacto} from "../../../modulos/contacto/actions";
const shortid = require('shortid');

export default {
    props:{
        regiones:Array,
        editarTrabajador:Boolean
    },
    computed:{
      ...mapState('contacto',['contactoForm','contacto','maximo_contacto','mostareditarContacto','mostraragregarContacto']),
        maximo:function (){
          return this.maximo_contacto === 2 ? true : false;
      },


    },
    data() {
        return {
            comunas:[],
            alert_success:'alert-success',
            alert_danger:'alert-danger',
            success:false,
            danger:false,
            parentescos:[
                'hijo(a)',
                'padre',
                'conyuge',
                'madre',
                'abuelo(a)',
                'otro'
            ],
            otro_parentesco:false
        }
    },
    validations: {
        contactoForm: {
            nombre: {required},
            apellido:{required},
            telefono:{required},
            correo:{required,email},
            direccion:{required},
            region_id:{required},
            comuna_id:{required},
            parentesco:{required}
        }
    },
    methods:{
        ...mapActions('contacto',['addContactos','comprobar_maximo','generateID','deleteContacto','obtenerContacto','updateContacto']),
      async  cargarCitiesContacto(){
            let id = this.contactoForm.region_id

          await  axios.get('/comunas/'+id).then(res=>{
                this.contactoForm.comuna_id = '0'
                this.comunas = res.data
            })
        },
        agregarContacto:function (event)
        {
            console.log(this.$v)
            this.$v.$touch()
            if (this.$v.$invalid) {
                this.danger = true
                console.log('error en el envio de formulario')
                console.log(this.$v.contactoForm.nombre.required)
            }else {
                let id = shortid.generate()
                this.generateID(id)
                this.addContactos()
                this.comprobar_maximo()
            }

        },
        editarContacto:function (event)
        {
            console.log(this.$v)
            this.$v.$touch()
            if (this.$v.$invalid) {
                this.danger = true
                console.log('error en el envio de formulario')
                console.log(this.$v.contactoForm.nombre.required)
            }else {
                //let id = shortid.generate()
                //this.generateID(id)
                this.updateContacto(this.contactoForm)
                //this.comprobar_maximo()
            }

        },
        OtroParentesco:function (){
            let parentesco = this.contactoForm.parentesco
            //console.log(this.contactoForm.parentesco)
            if (parentesco=== 'otro'){
                this.otro_parentesco = true
            }else{
                this.otro_parentesco = false
            }
        }
    }
}
</script>

<style scoped>
/* Las animaciones de entrada y salida pueden usar */
/* funciones de espera y duración diferentes.      */
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
