<template>
   <div>
       <div class="row my-5 mx-5">
           <div class="col-md-6 mb-2">
               <label class="fs-6 fw-semibold mb-2">Nombres</label>
               <input
                   :class="`form-control form-control-solid ${isDisabledInput ? 'disabled' : ''}`"
                   type="text"
                   v-model="nombre"
                   :disabled="isDisabledInput"
               />

               <input
                   v-if="isEdit"
                   :class="`form-control form-control-solid ${isDisabledInput ? 'disabled' : ''}`"
                   type="hidden"
                   v-model="id"
                   :disabled="isDisabledInput"
               />
           </div>

           <div class="col-md-6 mb-2">
               <label class="fs-6 fw-semibold mb-2">Apellidos</label>
               <input
                   :class="`form-control form-control-solid ${isDisabledInput ? 'disabled' : ''}`"
                   type="text"
                   v-model="apellido"
                   :disabled="isDisabledInput"
               />
           </div>

           <div class="col-md-6 mb-2">
               <label class="fs-6 fw-semibold mb-2">Teléfono</label>
               <input
                   :class="`form-control form-control-solid ${isDisabledInput ? 'disabled' : ''}`"
                   type="text"
                   v-model="telefono"
                   :disabled="isDisabledInput"
               />
           </div>

           <div class="col-md-6 mb-2">
               <label class="fs-6 fw-semibold mb-2">Correo</label>
               <input
                   :class="`form-control form-control-solid ${isDisabledInput ? 'disabled' : ''}`"
                   type="text"
                   v-model="correo"
                   :disabled="isDisabledInput"
               />
           </div>

           <div class="col-md-12 mb-2">
               <label class="fs-6 fw-semibold mb-2">Direccion</label>
               <input
                   :class="`form-control form-control-solid ${isDisabledInput ? 'disabled' : ''}`"
                   type="text"
                   v-model="direccion"
                   :disabled="isDisabledInput"
               />
           </div>

           <div class="col-md-6 mb-2">
               <label class="fs-6 fw-semibold mb-2">Region</label>
               <select v-model="region_id" class="form-select form-select-solid" @change="handleRegionChange">
                   <option :selected="true">---Seleccione---</option>
                   <option v-for="(region, index) in regiones" :key="index" :value="region.id">
                       {{ region.nombre_region }}
                   </option>
               </select>

           </div>

           <div class="col-md-6 mb-2">
               <label class="fs-6 fw-semibold mb-2">Comunas</label>
               <select v-model="comuna_id" class="form-select form-select-solid" :disabled="disabledComunas" @change="setComunaName">
                   <option :selected="true">---Seleccione---</option>
                   <option v-for="(comuna, index) in comunas" :key="index" :value="comuna.id">
                       {{ comuna.nombre_comuna }}
                   </option>
               </select>
           </div>

           <div class="col-md-6 mb-2">
               <label class="fs-6 fw-semibold mb-2">Parentesco</label>
               <select v-model="parentesco" class="form-select form-select-solid">
                   <option :selected="true">---Seleccione---</option>
                   <option v-for="(parentesco, index) in parentescos" :key="index" :value="parentesco">
                       {{ parentesco }}
                   </option>
               </select>
           </div>
       </div>

       <div class="row my-5 mx-5">
           <div class="col-md-12">
               <button type="button" class="btn btn-primary btn-sm" @click="isEditar ? updateContacto() : addContacto()">
                   {{ isEditar ? 'Editar contacto' : 'Agregar contacto' }}
               </button>
           </div>
       </div>

       <div class="row my-5 mx-5">
           <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5 dataTable no-footer">
               <thead>
               <tr>
                   <th>Nombre</th>
                   <th>Apellido</th>
                   <th>Correo</th>
                   <th>Teléfono</th>
                   <th>Dirección</th>
                   <th>Comuna</th>
                   <th>Región</th>
                   <th>Acciones</th>
               </tr>
               </thead>
               <tbody>
               <tr v-for="contacto in contactos" :key="contacto.id"  v-if="contactos && contactos.length">
                   <td>{{ contacto.nombre }}</td>
                   <td>{{ contacto.apellido }}</td>
                   <td>{{ contacto.correo }}</td>
                   <td>{{ contacto.telefono }}</td>
                   <td>{{ contacto.direccion }}</td>
                   <td>{{ contacto.nombre_comuna  }}</td>
                   <td>{{ contacto.nombre_region }}</td>
                   <td>
                       <button type="button" class="btn btn-danger btn-sm" @click="deleteContacto(contacto.id)" title="eliminar">
                           <i class="fa fa-trash"></i>
                       </button>
                       <button type="button" class="btn btn-info btn-sm" @click="obtenerContacto(contacto.id)" title="editar">
                           <i class="fa fa-edit"></i>
                       </button>
                   </td>
               </tr>
               </tbody>
           </table>
       </div>
   </div>
</template>

<script>
import {mapActions, mapState} from "vuex";

export default {
    props: {
        form: {
            type: Object,
            required: true,
        },
        isEdit: {
            type: Boolean,
            required: false,
            default: false,
        },
    },
    data() {
        return {
            contactos: [], // Asegúrate de llenar esto con los datos iniciales como sea necesario
            // Otras propiedades de datos necesarias...
            parentescos: [
                'hijo(a)',
                'padre',
                'conyuge',
                'madre',
                'abuelo(a)',
                'otro'],
            nombre: '',
            apellido: '',
            telefono: '',
            correo: '',
            direccion: '',
            region_id: '',
            comuna_id: '',
            parentesco: '',
            isEditar: false,
            id: '',
            disabledComunas: true,
            nombre_region: '',
            isDisabledInput: false,
            nombre_comuna: '',

        };
    },
    computed: {
        // Otras propiedades computadas necesarias...
        ...mapState({
            regiones: state => state.regiones.regiones,
            comunas: state => state.comunas.comunas,
        }),

    },
    created() {
        this.loadRegiones();
    },
    watch: {
        'form.contactos': {
            immediate: true,
            handler(contactos) {
                if(this.isEdit && Array.isArray(contactos)) {
                    this.contactos = [...contactos];
                }
            }
        }
    },
    methods: {
        ...mapActions({
            loadRegiones: 'regiones/fetchRegiones', // Asegúrate de usar los nombres correctos definidos en tu store
            loadComunas: 'comunas/fetchComunas',
            loadComunasId: 'comunas/fetchComunasById',
        }),
        handleRegionChange() {
            this.loadComunasId(this.region_id).then(() => {
                this.disabledComunas = false; // Habilita el select de comunas
            });
        },

        setComunaName() {
            const comunaSeleccionada = this.comunas.find(comuna => comuna.id === this.comuna_id);
            if (comunaSeleccionada) {
                this.nombre_comuna = comunaSeleccionada.nombre_comuna;
            }
        },
        resetForm() {
            this.nombre = '';
            this.apellido = '';
            this.telefono = '';
            this.correo = '';
            this.direccion = '';
            this.region_id = '';
            this.nombre_region = '';
            this.comuna_id = '';
            this.nombre_comuna = '';
            this.parentesco = '';
            this.isEditar = false;
            this.id = '';
        },
        addContacto() {
            // Primero, verifica si ya se alcanzó el máximo de contactos permitidos
            if (this.contactos.length >= 2) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pueden añadir más de dos contactos por trabajador.',
                });
                this.resetForm()
                return; // Detiene la ejecución del método si ya hay dos contactos
            }

            // Validate the form, create a new contact object, push it to the contactos array
            // Show a success message and reset the form
            if (!this.nombre || !this.apellido || !this.telefono || !this.correo || !this.direccion || !this.region_id || !this.comuna_id || !this.parentesco) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Por favor, complete todos los campos requeridos.',
                });
                return;
            }

            const nuevoContacto = {
                id: Date.now(),
                nombre: this.nombre,
                apellido: this.apellido,
                telefono: this.telefono,
                correo: this.correo,
                direccion: this.direccion,
                region_id: this.region_id,
                nombre_region: this.regiones.find(region => region.id === this.region_id).nombre_region,
                comuna_id: this.comuna_id,
                nombre_comuna: this.comunas.find(comuna => comuna.id === this.comuna_id).nombre_comuna,
                parentesco: this.parentesco,
            };

            this.contactos.push(nuevoContacto);
            this.form.contactos = [...this.contactos];
            this.resetForm();

            Swal.fire({
                icon: 'success',
                title: '¡Añadido!',
                text: 'El contacto ha sido añadido exitosamente.',
            });
        },

        // Method to edit an existing contact
        obtenerContacto(id) {
            const index = this.contactos.findIndex(contacto => contacto.id === id);
            if (index !== -1) {
                const contactoSeleccionado = this.contactos[index];
                this.id = contactoSeleccionado.id;
                this.nombre = contactoSeleccionado.nombre;
                this.apellido = contactoSeleccionado.apellido;
                this.telefono = contactoSeleccionado.telefono;
                this.correo = contactoSeleccionado.correo;
                this.direccion = contactoSeleccionado.direccion;
                this.region_id = contactoSeleccionado.region_id;
                this.comuna_id = contactoSeleccionado.comuna_id;
                this.parentesco = contactoSeleccionado.parentesco;
                this.isEditar = true;
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Contacto no encontrado.',
                });
            }
        },

        // Method to update an existing contact
        updateContacto() {
            const index = this.contactos.findIndex(contacto => contacto.id === this.id);

            if (index !== -1) {
                this.$set(this.contactos, index, {
                    id: this.id,
                    nombre: this.nombre,
                    apellido: this.apellido,
                    telefono: this.telefono,
                    correo: this.correo,
                    direccion: this.direccion,
                    region_id: this.region_id,
                    comuna_id: this.comuna_id,
                    parentesco: this.parentesco,
                });
                this.form.contactos = [...this.contactos];
                Swal.fire({
                    icon: 'success',
                    title: 'Actualizado',
                    text: 'El contacto ha sido actualizado exitosamente.',
                });

                this.isEditar = false;
                this.resetForm();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se encontró el contacto para actualizar.',
                });
            }
        },

        // Method to delete a contact
        deleteContacto(id) {
            const index = this.contactos.findIndex(contacto => contacto.id === id);
            if (index !== -1) {
                this.contactos.splice(index, 1); // Elimina el contacto del arreglo
                this.form.contactos = [...this.contactos]; // Actualiza los contactos en el formulario principal
                Swal.fire({
                    icon: 'success',
                    title: 'Eliminado',
                    text: 'El contacto ha sido eliminado exitosamente.',
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se encontró el contacto para eliminar.',
                });
            }
        },


    },
};
</script>

<style scoped>
/* Estilos específicos del componente */
</style>

