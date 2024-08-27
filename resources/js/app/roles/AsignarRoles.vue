<template>
    <div>
        <CardComponent :isHeader="false" :isFooter="true" :customClass="'mb-5'">
            <template #body>
                <div class="row mb-3">
                    <div class="col-md-6 form-group">
                        <label for="trabajador_id" class="form-label">Trabajador</label>
                        <!--                                <select-2
                                                            v-model="trabajador_id"
                                                            dataType="number"
                                                        >
                                                            <option v-for="(trabajador, index) in trabajadores"  :value="trabajador.id">{{trabajador.rut+' - '+trabajador.primer_nombre +' '+ trabajador.primer_apellido +' ' +trabajador.segundo_apellido}}</option>
                                                        </select-2>-->
                        <v-select
                            :options="formattedTrabajador"
                            label="label"
                            class="form-control form-control-solid"
                            :reduce="trabajador => trabajador.id" v-model="trabajador_id"
                            style="padding:0px !important"
                        ></v-select>
                    </div>
                    <div class="col-md-12  mt-3 form-group">
                        <label for="accion" class="form-label">Acción</label>
                        <div>
                            <label v-for="(accion, index) in acciones" :key="index" style="margin-right: 10px">
                                <input type="radio" :value="accion" v-model="accion_seleccionada"
                                       class="form-check-input">
                                {{ accion }}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="rol" class="form-label">Roles</label>
                        <div class="row">
                            <div class="col-4 mb-2" v-for="rol in sortedRoles" :key="rol.id">
                                <label>
                                    <input class="form-check-input" type="checkbox" :value="rol.name"
                                           v-model="selectedRoles">
                                    {{ rol.name.toUpperCase() }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <template #footer>
                <button class="btn btn-success btn-sm" @click="enviar_cambio_roles">Guardar</button>
                <a href="/roles-usuarios" class="btn btn-secondary btn-sm">Volver</a>
            </template>
        </CardComponent>
        <CardComponent :isHeader="false" :isFooter="false">
            <template #body>
                <div class="row" style="margin-top: 40px">
                    <div class="col-md-12">
                        <h3>Usuarios con roles</h3>
                        <table class="table table-striped">
                            <thead>
                            <tr class="fw-bold fs-6 text-gray-800">
                                <th>Rut</th>
                                <th>Nombre</th>
                                <th>Roles</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(trabajador, index) in trabajador_role_sorted">
                                <td>
                                    <div class="rut-container">
                                        <span>{{ trabajador.rut }}</span>
                                        <span class="copy" @click="copyRUT(trabajador.rut)">
                                            <i class="fas fa-copy"></i>
                                        </span>
                                    </div>
                                </td>
                                <td>{{ trabajador.name + ' ' + trabajador.apellidos }}</td>
                                <td>
                                    <span class="badge badge-info" style="margin-right:10px "
                                          v-for="rol in trabajador.roles">
                                        {{ rol.name.toUpperCase() }}
                                    </span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <paginate :pagination="trabajadoresPage" :onPageChange="TrabajadorRole"></paginate>
                </div>
            </template>
        </CardComponent>

    </div>
</template>

<script>

import CardComponent from "@/components/CardComponent.vue";
import Select2 from "@/components/Form/Select2.vue";
import Paginate from "@/components/paginate.vue";

export default {
    components: {
        CardComponent,
        Select2,
        Paginate
    },
    computed: {
        sortedRoles() {
            return this.roles.slice().sort((a, b) => a.name.localeCompare(b.name));
        },
        trabajador_role_sorted() {
            return this.trabajador_role.sort((a, b) => {
                let nameA = a.roles[0].name.toUpperCase(); // convertir el rol name a mayúsculas para que el ordenamiento sea insensible a las mayúsculas y minúsculas
                let nameB = b.roles[0].name.toUpperCase();
                if (nameA < nameB) {
                    return -1;
                }
                if (nameA > nameB) {
                    return 1;
                }
                return 0;
            });
        },
        formattedTrabajador() {
            return this.trabajadores.map(trabajador => ({
                id: trabajador.id,
                label: trabajador.rut + ' - ' + trabajador.primer_nombre + ' ' + trabajador.segundo_nombre + ' ' + trabajador.primer_apellido + ' ' + trabajador.segundo_apellido
            }));
        }
    },
    data() {
        return {
            trabajador_id: 0,
            rol: '',
            roles: [],
            selectedRoles: [],
            mensaje: '',
            respuesta: false,
            alerta: '',
            mensajes: '',
            errors: [],
            inputClass: 'form-control mb-4',
            errorsClass: '',
            trabajadores: [],
            acciones: ['Asignar Rol', 'Remover rol'],
            accion_seleccionada: '',
            trabajador_role: [],
            trabajadoresPage: [],
        }
    },
    mounted() {
        this.getRoles()
        this.getTrabajadores()
        this.TrabajadorRole()
    },
    updated() {
        this.refrescar()
    },
    methods: {
        async getTrabajadores() {
            await axios.get('/lista-trabajadores').then((res) => {
                this.trabajadores = res.data
            }).catch((error) => {
                console.log(error)
            });
        },
        async TrabajadorRole(page = 1) {
            await axios.get('/rolesUsuario?page=' + page).then((res) => {
                this.trabajador_role = res.data.data
                this.trabajadoresPage = res.data
            }).catch((error) => {
                console.log(error)
            })
        },
        async getRoles() {
            await axios.get('/getRoles').then((res) => {
                this.roles = res.data
            }).catch((error) => {
                console.log(error)
            })
        },
        async enviar_cambio_roles() {
            let formData = new FormData
            formData.append('trabajador_id', this.trabajador_id)
            formData.append('roles', JSON.stringify(this.selectedRoles))
            formData.append('accion_seleccionada', this.accion_seleccionada)


            await axios.post('/asignar-roles-create', formData).then((res) => {

                if (this.accion_seleccionada === 'Asignar Rol') {
                    Swal.fire({
                        title: 'Rol asignado exitosamente',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    this.TrabajadorRole()
                    this.resetearFomulario()
                } else {
                    Swal.fire({
                        title: 'Rol removido exitosamente',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    this.TrabajadorRole()
                    this.resetearFomulario()
                }

            }).catch((error) => {
                this.respuesta = true
                this.alerta = 'alert-danger'
                this.mensajes = 'Error al enviar el formulario'
                this.errorsClass = 'form-control is-invalid';
                console.log(error)
            })
        },
        resetearFomulario() {
            this.trabajador_id = ''
            this.accion_seleccionada = ''
            this.selectedRoles = []
        },
        copyRUT(rut) {
            if (typeof rut !== 'string') {
                this.$swal('Error', 'El RUT proporcionado no es válido', 'error');
                return;
            }

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(rut).then(() => {
                    this.$swal('RUT copiado');
                }).catch(err => {
                    console.error('Error al copiar el RUT: ', err);
                    this.$swal('Error', 'No se pudo copiar el RUT al portapapeles', 'error');
                });
            } else {
                // Fallback to older method if Clipboard API is not available
                const textarea = document.createElement('textarea');
                textarea.value = rut;
                document.body.appendChild(textarea);
                textarea.select();
                try {
                    const successful = document.execCommand('copy');
                    document.body.removeChild(textarea);
                    if (successful) {
                        this.$swal('RUT copiado');
                    } else {
                        this.$swal('Error', 'No se pudo copiar el RUT al portapapeles', 'error');
                    }
                } catch (err) {
                    document.body.removeChild(textarea);
                    console.error('Fallback: Error al copiar el RUT: ', err);
                    this.$swal('Error', 'No se pudo copiar el RUT al portapapeles', 'error');
                }
            }
        }


    }
}
</script>

<style scoped>
.rut-container {
    display: inline-flex;
    align-items: center;
}

.rut-container > span {
    margin-right: 8px;
}

.copy {
    cursor: pointer;
}

.copy:hover {
    color: #0d6efd;
}

.copy:active {
    color: #0d6efd;
}


</style>
