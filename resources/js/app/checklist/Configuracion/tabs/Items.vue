<template>
    <div class="col-lg-11 mx-auto">
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm" @click="openModal(0)">
                        <i class="fa fa-plus"></i> Agregar </button>
<!--                    <button type="button" class="btn btn-primary btn-sm" @click="abirImportModal()">
                        importar
                    </button>-->
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                    <select v-model="filtro_tipo_id"
                            id="type_id"
                            class="form-select form-select-solid"
                            @change="cargarItems()">
                    >
                        <option v-for="tipo in tipos" :value="tipo.id">{{ tipo.name }}</option>
                    </select>
                </div>
            </div>
        </div>


        <div class="row mt-3">
            <div class="col-md-12">
                <simpleTable
                    :data="items"
                    :columns="columns"
                    @delete="eliminarItem"
                    @edit="openModal"/>
            </div>


        </div>
        <div class="row">
            <div class="col-md-11">
                <paginate :pagination="itemsPaginate" :onPageChange="cargarItems"></paginate>
            </div>

        </div>
        <!-- Modal -->
        <BootstrapModal :id="'ItemModalAdd'"
                        :title="'Agregar Item'"
                        :customClass="'modal-dialog-centered mw-650px'"
                        :hideCloseButton="false"
                        :onCloseButton="closeModal">
            <template #body>
                <div class="form fv-plugins-bootstrap5 fv-plugins-framework">
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="fs-6 fw-semibold mb-2" for="">Nombre Item</label>
                        <input type="text" v-model="name" id="name" class="form-control form-control-solid">
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="fs-6 fw-semibold mb-2" for="">Descripción Item</label>
                        <input type="text" v-model="description" id="description"
                               class="form-control form-control-solid">
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="fs-6 fw-semibold mb-2" for="">Tipo</label>
                        <select v-model="type_id" id="type_id" class="form-select form-select-solid ">
                            <option v-for="tipo in tipos" :value="tipo.id">{{ tipo.name }}</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="fs-6 fw-semibold mb-2" for="">Área</label>
                        <select v-model="area_id" id="area_id" class="form-select form-select-solid ">
                            <option v-for="area in areas" :value="area.id">{{ area.descripcion_area }}</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="fs-6 fw-semibold mb-2" for="">Item con observaciones</label>
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="tiene_discapacidad"
                                   v-model="is_observation"

                            />
                            <label class="form-check-label fw-semibold text-gray-400 ms-3" for="status"></label>
                        </div>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="fs-6 fw-semibold mb-2" for="">¿Lleva adjuntos?</label>
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="tiene_discapacidad"
                                   v-model="is_attachement"


                            />
                            <label class="form-check-label fw-semibold text-gray-400 ms-3" for="status"></label>
                        </div>
                    </div>

                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="fs-6 fw-semibold mb-2" for="">¿Posee Conteo de asientos?</label>
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="tiene_discapacidad"
                                   v-model="is_seats"

                            />
                            <label class="form-check-label fw-semibold text-gray-400 ms-3" for="status"></label>
                        </div>
                    </div>

                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="fs-6 fw-semibold mb-2" for="">¿Chequeo de tripulacion?</label>
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="tiene_discapacidad"
                                   v-model="is_tripulacion"

                            />
                            <label class="form-check-label fw-semibold text-gray-400 ms-3" for="status"></label>
                        </div>
                    </div>

                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="fs-6 fw-semibold mb-2" for="">¿Conteo de objecto de bus?</label>
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="tiene_discapacidad"
                                   v-model="is_conteo"

                            />
                            <label class="form-check-label fw-semibold text-gray-400 ms-3" for="status"></label>
                        </div>
                    </div>

                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="fs-6 fw-semibold mb-2" for="">Respuestas</label>
                        <input type="text" v-model="respuestas" id="respuestas" class="form-control form-control-solid" placeholder="SI,NO,NA">
                    </div>

                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="fs-6 fw-semibold mb-2" for="">Requerido</label>
                        <select v-model="requerido" id="requerido" class="form-select form-select-solid ">
                            <option v-for="critical in criticalArea" :value="critical.key">{{ critical.value }}</option>
                        </select>
                    </div>

                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="fs-6 fw-semibold mb-2" for="">Prioridad</label>
                        <select v-model="prioridad" id="requerido" class="form-select form-select-solid ">
                            <option v-for="prioridad in prioridades" :value="prioridad.key">{{ prioridad.value }}</option>
                        </select>
                    </div>

                    <div class="row mb-8">
                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                            <label class="fs-6 fw-semibold mb-2" for="">Responsables</label>
                            <select-2
                                v-model="responsibles_id"
                                dataType="number"
                                :modalId="'ItemModalAdd'"
                            >
                                <option
                                    v-for="({id, rut, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido}, index) in workers"
                                    :value="id"
                                >
                                    {{
                                        rut + ' ' + primer_nombre + ' ' + segundo_nombre + ' ' + primer_apellido + ' ' + segundo_apellido
                                    }}
                                </option>
                            </select-2>


                        </div>
                        <div class="col-md-6 fv-row fv-plugins-icon-container mt-7">
                            <button class="btn btn-sm btn-primary" @click="addResponsibles">
                                <i class="fa fa-plus"></i>
                                Agregar
                            </button>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-flush align-middle table-row-bordered table-row-solid gy-4 gs-9">
                            <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th>RUT</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody ref="sortable">
                            <tr
                                v-for="({id,rut,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido}, index) in responsibles"

                            >
                                <td>{{ rut }}</td>
                                <td>
                                    {{
                                        primer_nombre + ' ' + segundo_nombre + ' ' + primer_apellido + ' ' + segundo_apellido
                                    }}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-danger btn-sm" @click.prevent="removeResponsible(id)"><i
                                            class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </template>
            <template #footer>
                <!-- Contenido del pie de página del modal -->
                <button
                    type="button"
                    class="btn btn-primary btn-sm"
                    @click.prevent="guardarItem()"
                >
                    Guardar
                </button>

            </template>

        </BootstrapModal>
        <BootstrapModal :id="'itemImport'"
                        :title="'Importar Item'"
                        :customClass="'modal-dialog-centered mw-650px'"
                        :hideCloseButton="false"
                        :onCloseButton="closeImportModal">

            <template #body>
                <div class="form fv-plugins-bootstrap5 fv-plugins-framework">
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="fs-6 fw-semibold mb-2" for="">Archivo</label>
                        <input type="file"
                               @change="handleFileUpload"
                               id="file"
                               class="form-control form-control-solid">
                    </div>
                </div>
            </template>
            <template #footer>
                <!-- Contenido del pie de página del modal -->
                <button
                    type="button"
                    class="btn btn-primary btn-sm"
                    @click.prevent="importarItem()"
                >
                    Importar
                </button>
            </template>


        </BootstrapModal>
    </div>
</template>

<script>

import Swal from 'sweetalert2'
import simpleTable from '@/components/simpleTable.vue'
import BootstrapModal from '@/components/modalComponent.vue'
import Select2 from "@/components/Form/Select2.vue";
import paginate from "@/components/paginate.vue";
export default {
    components: {
        Select2,
        simpleTable,
        BootstrapModal,
        paginate
    },
    data() {
        return {
            items: [],
            itemsPaginate: [],
            tipos: [],
            id: 0,
            name: '',
            description: '',
            type_id: '',
            file: '',
            columns: [
                {title: 'ID', field: 'id'},
                {title: 'Nombre', field: 'name'},
                {title: 'Descripción', field: 'description'},
                {title: 'Tipo', field: 'type.name'},
                {title: 'Acciones', field: 'acciones'}
            ],
            criticalArea:[
                {key:'approved', value: 'Aprobado'},
                { key:'approved with observation', value: 'Aprobado con observaciones'},
                {key: 'refused', value: 'Rechazado'}
            ],
            prioridad:'',
            prioridades:[
                {key:'baja', value: 'Baja'},
                { key:'media', value: 'Media'},
                {key: 'alta', value: 'Alta'}
            ],
            responsibles_id: 0,
            responsibles: [],
            workers: [],
            areas: [],
            area_id: '',
            is_attachement: false,
            is_seats: false,
            is_tripulacion: false,
            is_conteo: false,
            is_observation: false,
            respuestas: '',
            requerido: '',
            field_id: 0,
            filtro_tipo_id: 0
        }
    },

    methods: {
        async getAreas() {
            try {
                const {data, status} = await axios.get('/areas') // replace '/areas' with your actual API endpoint
                if (status === 200) {
                    this.areas = data
                }
            } catch (e) {
                console.log(e)
            }
        },
        async cargarItems(page = 1) {
            try {
                let url = '/checklist/item'

                if (page > 1) {
                    url = url + '?page=' + page
                }

                if (this.filtro_tipo_id !== 0){
                    url = '/checklist/item?filtro[type_id]=' + this.filtro_tipo_id
                }
                const {data, status} = await axios.get(url)
                if (status === 200) {
                    this.items = data.data
                    this.itemsPaginate = data
                }

            } catch (e) {
                console.log(e)
            }
        },
        addResponsibles() {
            let worker = this.workers.find(worker => worker.id === this.responsibles_id);
            if (worker) {
                this.responsibles.push(worker);
            }
            console.log(this.responsibles);
        },
        removeResponsible(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, bórralo!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.responsibles = this.responsibles.filter(worker => worker.id !== id);
                    console.log(this.responsibles);
                    Swal.fire(
                        '¡Eliminado!',
                        'El responsable ha sido eliminado.',
                        'success'
                    )
                }
            })
        },
        async getWorkers() {
            try {
                const {data, status} = await axios.get('/lista-trabajadores')
                if (status === 200) {
                    this.workers = data
                }

            } catch (e) {
                console.log(e)
            }
        },

        async getTipos() {
            try {
                const {data, status} = await axios.get('/checklist/tipo')
                if (status === 200) {
                    this.tipos = data
                }

            } catch (e) {
                console.log(e)
            }
        },
        openModal(idValue = 0) {
            this.id = idValue
            if (idValue == 0) {
                this.name = ''
                this.description = ''
                this.type_id = ''
                this.responsibles = []
            } else {
                let item = this.items.find((item) => item.id === this.id);
                console.log(item)
                this.name = item.name
                this.description = item.description
                this.type_id = item.type_id
                this.is_observation = item.is_observations === 'si' ? true : false
                this.is_attachement = item.is_attachement === 'si' ? true : false
                this.is_seats = item.is_seats === 'si' ? true : false
                this.is_tripulacion = item.is_tripulacion === 'si' ? true : false
                this.is_conteo = item.is_conteo === 'si' ? true : false
                this.respuestas = item.field.options
                this.requerido = item.critical
                this.prioridad = item.prioridad
                this.area_id = item.area_id
                this.field_id = item.field.id ? item.field.id : 0

                this.responsibles = item.responsables.map(responsable => responsable.trabajador);
            }
            $('#ItemModalAdd').modal('show')
        },
        async guardarItem() {
            let method = axios.post
            let url = this.id == 0 ? '/checklist/item' : '/checklist/item/' + this.id;
            //JSON.stringify(this.responsibles)
            let responsables = JSON.stringify(this.responsibles)
            await method(url, {
                name: this.name,
                description: this.description,
                type_id: this.type_id,
                is_observations: this.is_observations ? 'si' : 'no',
                is_attachement: this.is_attachement ? 'si' : 'no',
                is_seats: this.is_seats ? 'si' : 'no',
                is_tripulacion: this.is_tripulacion ? 'si' : 'no',
                is_conteo: this.is_conteo ? 'si' : 'no',
                options: this.respuestas,
                critical: this.requerido,
                prioridad: this.prioridad,
                area_id: this.area_id,
                field_id: this.field_id,
                responsibles: responsables
            }).then((res) => {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: this.id == 0 ? 'Item creado exitosamente' : 'Item editado exitosamente'
                })
                this.cargarItems()
                this.name = ''
                this.description = ''
                this.type_id = ''
                this.responsibles = []
                this.prioridad = ''
                this.respuestas = ''
                this.requerido = ''
                this.area_id = 0
                $('#ItemModalAdd').modal('hide')
            }).catch((error) => {
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Error al enviar el formulario'
                })
            })
        },
        async eliminarItem(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, bórralo!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/checklist/item/' + id).then((res) => {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Item eliminado exitosamente'
                        })
                        this.cargarItems()
                    }).catch((error) => {
                        Swal.fire({
                            icon: 'error',
                            title: '¡Error!',
                            text: 'Error al eliminar'
                        })
                    })
                }
            })
        },
        closeModal() {
            this.id = 0
            this.name = ''
            this.description = ''
            this.type_id = ''
            $('#ItemModalAdd').modal('hide')
        },
        abirImportModal() {
            $('#itemImport').modal('show')
        },
        closeImportModal() {
            this.file = ''
            $('#itemImport').modal('hide')
        },
        handleFileUpload(event) {
            this.file = event.target.files[0];
        },
        importarItem(){
            let formData = new FormData();
            formData.append('file', this.file);
            axios.post('/checklist/import-items', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((res) => {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Item importado exitosamente'
                })
                this.cargarItems()
                $('#itemImport').modal('hide')
            }).catch((error) => {
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Error al importar'
                })
            })
        }
    },
    mounted() {
        this.cargarItems();
        this.getTipos();
        this.getWorkers();
        this.getAreas();
    }
}
</script>

<style scoped>

</style>
