<template>
    <Stepper
        :categories="checklistItems"
        :initialStep="currentStep"
        :totalSteps="totalSteps"
        @step-changed="currentStep = $event.newStep"
        @request-validate="handleValidation"
        @go-back="goBack"
        @submit-page="submitPage"
    >

        <template #step-1>
            <div class="row mb-5">
                <div class="col-md-5 mb-5" v-if="isEdit">
                    <label class="fs-6 fw-semibold mb-2" for="">Bus</label>
                    <select
                        v-model="bus_id"
                        class="form-select form-select-solid"
                        :disabled="true"

                    >
                        <option
                            v-for="(bus, index) in buses"
                            :key="bus.id"
                            :value="bus.id">
                            {{ bus.numero_bus + ' - ' + bus.patente }}
                        </option>
                    </select>

                </div>
                <div class="col-md-5 mb-5" v-else>
                    <label class="fs-6 fw-semibold mb-2" for="">Bus</label>
                    <!--                    <select-2
                                            v-model="bus_id"
                                            dataType="number"
                                            label="Seleccione un bus"
                                        >
                                            <option
                                                v-for="(bus, index) in buses"
                                                :key="bus.id"
                                                :value="bus.id">
                                                {{ bus.numero_bus + ' - ' + bus.patente }}
                                            </option>
                                        </select-2>-->
                    <v-select
                        :options="formattedBuses"
                        label="label"
                        class="form-control form-control-solid"
                        :reduce="bus => bus.id" v-model="bus_id"
                        style="padding:0px !important"
                    ></v-select>

                </div>
                <div class="col-md-5 mb-5">
                    <label class="fs-6 fw-semibold mb-2" for="">Fecha</label>
                    <input type="date"
                           v-model="fecha"
                           class="form-control form-control-solid disabled"
                           :disabled="true"
                    >
                </div>
                <div class="col-md-5 mb-5">
                    <label class="fs-6 fw-semibold mb-2" for="">Modelo</label>
                    <input type="text"
                           v-model="modelo"
                           class="form-control form-control-solid disabled"
                           :disabled="true"
                    >
                </div>
                <div class="col-md-5 mb-5">
                    <label class="fs-6 fw-semibold mb-2" for="">Marca</label>
                    <input type="text"
                           v-model="marca"
                           class="form-control form-control-solid disabled"
                           :disabled="true"
                    >
                </div>
                <div class="col-md-5 mb-5">
                    <label class="fs-6 fw-semibold mb-2" for="">Kilometraje Anterior</label>
                    <input type="text"
                           v-model="kilometraje_ant"
                           class="form-control form-control-solid disabled"
                           :disabled="true"
                    >
                </div>
                <div class="col-md-5 mb-5">
                    <label class="fs-6 fw-semibold mb-2" for="">Kilometraje Actual</label>
                    <input type="number"
                           v-model="kilometrajeInput"
                           class="form-control form-control-solid"
                    >
                    <p class="text-danger" v-if="kilometrajeError">{{ kilometrajeError }}</p>
                </div>

            </div>
        </template>

      <template #step-2>
            <StepForm
                :respuestas="respuestas"
                :current-category-items="checklistItems.length && checklistItems.find(item=> item.id === 13) ? checklistItems.find(item=> item.id === 13) : {}"
                @updateRespuestas="updateRespuestas"
                @handleFileUpload="handleFileUpload"
                :image-previews="imagePreviews"
            />
        </template>

      <template #step-3>
            <StepForm
                :respuestas="respuestas"
                :current-category-items="checklistItems.length && checklistItems.find(item=> item.id === 14) ? checklistItems.find(item=> item.id === 14) : {}"
                @updateRespuestas="updateRespuestas"
                @handleFileUpload="handleFileUpload"
                :image-previews="imagePreviews"
            />
        </template>
        <template #step-4>
            <StepForm
                :respuestas="respuestas"
                :current-category-items="checklistItems.length && checklistItems.find(item=> item.id === 15) ? checklistItems.find(item=> item.id === 15) : {}"
                @updateRespuestas="updateRespuestas"
                @handleFileUpload="handleFileUpload"
                :image-previews="imagePreviews"
            />
        </template>

        <template #step-5>
            <StepForm
                :respuestas="respuestas"
                :current-category-items="checklistItems.length && checklistItems.find(item=> item.id === 16) ? checklistItems.find(item=> item.id === 16) : {}"
                @updateRespuestas="updateRespuestas"
                @handleFileUpload="handleFileUpload"
                :image-previews="imagePreviews"
            />
        </template>

        <template #step-6>
            <StepForm
                :respuestas="respuestas"
                :current-category-items="checklistItems.length && checklistItems.find(item=> item.id === 17) ? checklistItems.find(item=> item.id === 17) : {}"
                @updateRespuestas="updateRespuestas"
                @handleFileUpload="handleFileUpload"
                :image-previews="imagePreviews"
            />
        </template>

        <template #step-7>
            <StepForm
                :respuestas="respuestas"
                :current-category-items="checklistItems.length && checklistItems.find(item=> item.id === 18) ? checklistItems.find(item=> item.id === 18) : {}"
                @updateRespuestas="updateRespuestas"
                @handleFileUpload="handleFileUpload"
                :image-previews="imagePreviews"
            />
        </template>

        <template #step-8>
            <StepForm
                :respuestas="respuestas"
                :current-category-items="checklistItems.length && checklistItems.find(item=> item.id === 19) ? checklistItems.find(item=> item.id === 19) : {}"
                @updateRespuestas="updateRespuestas"
                @handleFileUpload="handleFileUpload"
                :image-previews="imagePreviews"
            />
        </template>
        <template #step-9>
            <StepForm
                :respuestas="respuestas"
                :current-category-items="checklistItems.length && checklistItems.find(item=> item.id === 20) ? checklistItems.find(item=> item.id === 20) : {}"
                @updateRespuestas="updateRespuestas"
                @handleFileUpload="handleFileUpload"
                :image-previews="imagePreviews"
            />
        </template>
        <template #step-10>
            <StepForm
                :respuestas="respuestas"
                :current-category-items="checklistItems.length && checklistItems.find(item=> item.id === 21) ? checklistItems.find(item=> item.id === 21) : {}"
                @updateRespuestas="updateRespuestas"
                @handleFileUpload="handleFileUpload"
                :image-previews="imagePreviews"
            />
        </template>

        <template #step-11>
            <StepForm
                :respuestas="respuestas"
                :current-category-items="checklistItems.length && checklistItems.find(item=> item.id === 22) ? checklistItems.find(item=> item.id === 22) : {}"
                @updateRespuestas="updateRespuestas"
                @handleFileUpload="handleFileUpload"
                :image-previews="imagePreviews"
            />
        </template>

        <template #step-12>
            <div class="row">
                <div class="col-md-12" v-for="(observacion, index) in observaciones" :key="index">
                    <label class="fs-6 fw-semibold mb-2" for="">Observacion {{ index + 1 }}</label>
                    <textarea
                        v-model="observaciones[index]"
                        class="form-control form-control-solid">
            </textarea>
                    <button @click="removeObservacion(index)" type="button" class="btn btn-danger mt-2"><i
                        class="fa fa-trash"></i></button>
                </div>
                <div class="col-md-12" v-if="observaciones.length < 10">
                    <button @click="addObservacion" type="button" class="btn btn-primary mt-2"><i
                        class="fa fa-plus-circle"></i></button>
                </div>
            </div>
        </template>


        <template #step-13>
            <div>
                <h1>Resumen</h1>
                <div class="resumen grid-container">
                    <div class="grid-item">
                        <p>Bus: {{ busDescripcion }}</p>
                    </div>
                    <div class="grid-item">
                        <p>Fecha: {{ fecha }}</p>
                    </div>

                    <div class="grid-item-full">
                        <p>Observaciones: {{ observaciones }}</p>
                    </div>
                </div>
                <div class="resumen">
                    <h4>Total: <span class="badge badge-secondary">{{ cantidadTotal }}</span></h4>
                    <h4>Aprobados: <span class="badge badge-success">{{ cantidadAprobados }}</span></h4>
                    <h4>Aprobados con Observaciones: <span
                        class="badge badge-warning">{{ cantidadAprobadosConObservaciones }}</span></h4>
                    <h4>Rechazados: <span class="badge badge-danger">{{ cantidadRechazados }}</span></h4>
                    <h4>NA: <span class="badge badge-info">{{ cantidadNA }}</span></h4>
                </div>
                <div v-if="respuestasAprobadasConObservaciones.length > 0">
                    <h1 class="mb-5">Aprobados con observaciones</h1>
                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th>ID</th>
                            <th>Item</th>
                            <th>Respuesta</th>
                            <th>Observaciones</th>
                            <th>Resultado</th>
                        </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                        <tr v-for="item in respuestasAprobadasConObservaciones" :key="item.id">
                            <td>{{ item.id }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ item.respuesta }}</td>
                            <td>{{ item.observaciones }}</td>
                            <td>{{ item.respuesta_add }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="respuestasRechazadas.length > 0">
                    <h1 class="mb-5">Rechazados</h1>

                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th>ID</th>
                            <th>Item</th>
                            <th>Respuesta</th>
                            <th>Observaciones</th>
                            <th>Resultado</th>
                        </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                        <tr v-for="item in respuestasRechazadas" :key="item.id">
                            <td>{{ item.id }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ item.respuesta }}</td>
                            <th>{{ item.observaciones }}</th>
                            <td>{{ item.respuesta_add }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div v-if="itemResidencias.length > 0 || respuestasRechazadas.length > 0 || respuestasAprobadasConObservaciones.length > 0 ">
                    <h1 class="mb-5">Items con reincidencias</h1>
                    <data-table
                        :items="itemResidencias"
                        :columns="columnas"
                    >
                    </data-table>

                </div>
                <div v-if="observaciones.length > 0">
                    <h1 class="mb-5">Observaciones</h1>
                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th>Nº</th>
                            <th>Observaciones</th>
                        </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                        <tr v-for="(observacion,index) in observaciones">
                            <td>{{index +1}}</td>
                            <td>{{ observacion }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div v-if="respuestasRechazadas.length > 0 || respuestasAprobadasConObservaciones.length > 0">
                    <div class="col-md-8 mb-5">
                        <label class="fs-6 fw-semibold mb-2" for="">Areas</label>
                        <select v-model="area_id" class="form-select form-select-solid">
                            <option v-for="area in areas" :value="area.id">{{ area.name }}</option>
                        </select>
                    </div>
                    <div class="col-md-8 mb-5">
                        <label class="fs-6 fw-semibold mb-2" for="">Trabajador</label>
                        <v-select
                            :options="formattedTrabajadores"
                            placeholder="Trabajadores"
                            class="form-control form-control-solid"
                            :reduce="trabajador => trabajador.id" v-model="trabajador_id"
                            style="padding:0px !important"
                        ></v-select>
                    </div>
                    <div class="col-md-5">
                        <label for="tiene_discapacidad" class="fs-6 fw-semibold mb-2">¿Acepta Firmar?</label>
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="tiene_discapacidad"
                                   v-model="isAgreeSigned"
                            />
                            <label class="form-check-label fw-semibold text-gray-400 ms-3" for="status"></label>
                        </div>
                    </div>

                    <div v-if="isAgreeSigned">
                        <div class="col-md-8 mb-5">
                            <label class="fs-6 fw-semibold mb-2">Contraseña</label>
                            <div class="input-group">
                                <input :type="showPassword ? 'text' : 'password'" v-model="password"
                                       class="form-control form-control-solic">
                                <button class="btn btn-outline-secondary" type="button"
                                        @click="showPassword = !showPassword">
                                    <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                </button>
                            </div>
                            <p class="text-danger" v-if="passwordError">{{ passwordError }}</p>
                        </div>
                        <div class="col-md-8 mb-5">
                            <label class="fs-6 fw-semibold mb-2">Repetir Contraseña</label>
                            <div class="input-group">
                                <input :type="showPassword ? 'text' : 'password'" v-model="password_repeat"
                                       class="form-control form-control-solic">
                                <button class="btn btn-outline-secondary" type="button"
                                        @click="showPassword = !showPassword">
                                    <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                </button>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-8 mb-5" v-else>
                        <label class="fs-6 fw-semibold mb-2" for="">Observación</label>
                        <textarea class="form-control form-control-solic" v-model="observacion" rows="3"></textarea>
                    </div>

                    <div class="col-md-8 mb-5">
                        <button type="button" @click="addFirmante"
                                class="btn btn-primary">Firmar</button>
                    </div>

                    <h1>Usuario que Firmaron</h1>
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Area</th>
                                <th>Fecha</th>
                                <th>Observaciones</th>
                                <th>Estado</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="user in users" :key="user.id">
                                <td>{{ user.nombre + ' ' + user.apellidos }}</td>
                                <td>{{ user.area_name }}</td>
                                <td>{{ user.fecha }}</td>
                                <td>{{user.observaciones}}</td>
                                <td>{{ user.estado === 1 ? 'firmado' : 'no firmado' }}</td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>

        </template>
    </Stepper>
</template>

<script>
import CardComponent from "@/components/CardComponent.vue";
import Select2 from "@/components/Form/Select2.vue";
import Stepper from "@/components/Stepper.vue";
import StepForm from "./form/StepForm.vue";
import SelectCustom from '@/components/Form/SelectCustom.vue';
import DataTable from "@/components/DataTable.vue";
export default {
    props: {
        checklist_id: {
            type: Number,
            default: 0
        },
        id_bus: {
            type: Number,
            default: 0
        }

    },
    components: {
        StepForm,
        Select2,
        CardComponent,
        Stepper,
        SelectCustom,
        DataTable
    },
    computed: {

        currentCategoryItems() {
            let copiaChecklistItems = this.checklistItems;
            console.log(copiaChecklistItems)
            let items = copiaChecklistItems.find(item => item.id === this.currentStep);
            console.log(items)
            return items;
        },
        busDescripcion() {
            const bus = this.buses.find(bus => bus.id === this.bus_id);
            return bus ? `${bus.numero_bus}-${bus.patente}` : 'Bus no encontrado';
        },
        destinoCiudad() {
            const destino = this.destinos.find(destino => destino.id === this.destino_id);
            return destino ? destino.ciudad : 'Destino no encontrado';
        },
        cantidadTotal() {
            // Retorna la cantidad de llaves en el objeto 'respuestas', que representa el número total de respuestas.
            return Object.keys(this.respuestas).length;
        },
        cantidadAprobados() {
            return Object.values(this.respuestas).filter(item => item.respuesta === 'SI').length;
        },
        cantidadAprobadosConObservaciones() {
            // Filtra las respuestas con 'NO' y 'critical' igual a 'approved with observation'.
            return Object.values(this.respuestas).filter(item => item.respuesta === 'NO' || item.valor === 'NO' && item.critical === 'approved with observation').length;
        },
        cantidadRechazados() {
            // Filtra las respuestas con 'NO' y 'critical' igual a 'refused'.
            return Object.values(this.respuestas).filter(item => item.respuesta === 'NO' || item.valor === 'NO' && item.critical === 'refused').length;
        },

        cantidadNA() {
            return Object.values(this.respuestas).filter(item => item.respuesta === 'NA').length;
        },
        //devuelve solo la rechazadas para el resumen
        respuestasRechazadas() {
            // Filtra y retorna respuestas 'NO' con 'critical' igual a 'refused'.
            return Object.values(this.respuestas).filter(item => (item.respuesta === 'NO' || item.valor === 'NO') && item.critical === 'refused');
        },
        //devuelve las aprobadas con observaciones para el resumen
        respuestasAprobadasConObservaciones() {
            // Filtra y retorna respuestas 'NO' con 'critical' igual a 'approved with observation'.
            return Object.values(this.respuestas).filter(item => (item.respuesta === 'NO' || item.valor === 'NO') && item.critical === 'approved with observation');
        },
        formattedBuses() {
            return this.buses.map(bus => ({
                id: bus.id,
                label: bus.numero_bus + ' - ' + bus.patente
            }));
        },
        formattedTrabajadores() {
            return this.trabajadores.map((trabajador) => {
                return {
                    id: trabajador.id,
                    label: trabajador.rut + ' - ' + trabajador.name + ' ' + trabajador.apellidos
                };
            });
        },
        kilometrajeInput: {
            get() {
                // Devuelve el valor actual de kilometraje_act para el input.
                return this.kilometraje_act;
            },
            set(value) {
                // Realiza la validación cuando el usuario intenta cambiar el valor.
                if (value >= this.kilometraje_ant) {
                    // Si el nuevo valor es válido, actualiza kilometraje_act.
                    this.kilometraje_act = value;
                    this.kilometrajeError = '';
                } else {
                    // Si el nuevo valor no es válido, establece un mensaje de error.
                    // No necesitas cambiar kilometraje_act aquí.
                    this.kilometrajeError = 'El kilometraje actual no puede ser menor que el kilometraje anterior';
                }
            }
        }
    },
    data() {
        return {
            currentStep: 1,
            checklistItems: [],
            currentPage: 0,
            respuestas: {},
            observaciones: [],
            bus_id: 0,
            buses: [],
            fecha: this.formatDate(new Date()),// Fecha seleccionada por el usuario
            fechaMinima: '', //
            kilometraje_ant: 0,
            kilometraje_act: 0,
            marca: '',
            modelo: '',
            kilometrajeError:'',
            totalSteps: 0,
            imagePreviews: {},
            validate_success: false,
            hora_salida: '',
            category_id: 2,
            isEdit: false,
            isProgramacion: false,
            asientos_cama: 0,
            asientos_semicama: 0,
            asientos_premium: 0,
            asientos_mixto: 0,
            tipoBusSeleccionado: '',
            columns: [{
                key: 'id',
                label: 'ID',
            },
                {
                    key: 'name',
                    label: 'Nombre',
                },
                {
                    key: 'respuesta',
                    label: 'Respuesta',
                },
                {
                    key: 'observaciones',
                    label: 'Observaciones',
                },
            ],
            columnas:[
                {
                    key: 'ITEM_NAME',
                    label: 'Nombre'
                },
                {
                    key: 'BUS',
                    label: 'Bus'
                },
                {
                    key: 'NROS_TICKET',
                    label: 'Folios'
                },
                {
                    key: 'TOTAL_TICKET',
                    label: 'Total Ticket'
                }
            ],
            itemResidencias: [],
            areas: [
                {id: 28, name: 'Prevencion'},
                {id: 8, name: 'Informatica'},
                {id: 9, name: 'Mantención'},
                {id: 12, name: 'Operaciones'},
                {id: 10, name: 'Montitoreo'},

            ],
            area_id: 0,
            trabajador_id: 0,
            password: '',
            trabajadores: [],
            password_repeat: '',
            users: [],
            showPassword: false,
            isAgreeSigned: true,
            observacion: '',
            passwordError: '',
        };
    },
    watch: {
        bus_id(newBusId) {
            const selectedBus = this.buses.find(bus => bus.id === newBusId);
            console.log(selectedBus)
            if (selectedBus) {
                this.modelo = selectedBus.modelo_carroceria;
                this.marca = selectedBus.marca_carroceria;

                this.fetchBusRevisionData();
            }
        },
        password(newVal) {
            this.validatePassword();
        },
        password_repeat(newVal) {
            this.validatePassword();
        },
        area_id(newVal) {
            this.getTrabajadoresAll();
        }
    },
    methods: {

        parseOptions(options) {
            return options.split(',');
        },
        formatDate(date) {
            let d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [year, month, day].join('-');
        },

        async fetchChecklistData() {
            try {
                // Determina la URL basada en si es una edición y el ID del checklist
                let url = this.checklist_id ? `/checklist-structure-prevencion/2?checklist_id=${this.checklist_id}` : '/checklist-structure-prevencion/2';
                if (this.checklist_id) {
                    this.isEdit = true;
                }

                const {data} = await axios.get(url);
                this.checklistItems = data;
                this.totalSteps = data.length;

                let newRespuestas = {};

                // Función recursiva para procesar items y sus children
                const processItems = (items) => {
                    items.forEach(item => {
                        newRespuestas[item.id] = {
                            id: item.id,
                            name: item.name,
                            respuesta: item.responses ? item.responses[0].respuesta : null,
                            valor: item.responses ? item.responses[0].valor : null,
                            observaciones: item.responses ? item.responses[0].observaciones : '',
                            respuesta_add: item.responses ? item.responses[0].respuesta_add : '',
                            images: item.responses ? item.responses[0].images : null,
                            critical: item.critical, // 'approved with observation', 'refused'
                            isConteo: item.is_conteo === 'si' ? true : false,
                        };

                        // Procesar children si existen
                        if (item.children && item.children.length) {
                            processItems(item.children);
                        }
                    });
                };

                // Itera sobre cada checklist y procesa sus items
                data.forEach(checklist => {
                    processItems(checklist.items);
                });

                // Asigna el nuevo objeto de respuestas
                this.respuestas = newRespuestas;

                console.log(this.respuestas)

            } catch (error) {
                console.error('Error fetching checklist data:', error);
                // Implementa aquí tu lógica de manejo de errores
            }
        },

        async fetchBusRevisionData() {
            try {
                const {data, status} = await axios.get(`/getBusRevisionData/${this.bus_id}`);

                if (status === 200) {
                    this.kilometraje_ant = data.kilometraje;
                }
            } catch (error) {
                console.error('Error fetching bus revision data:', error);
                this.kilometraje_ant = 0;
            }
        },

        /*obtenerAsientosYTipo() {
            let busSeleccionado = this.buses.find(bus => bus.id === this.bus_id);
            if (busSeleccionado) {
                // Asumiendo que bus tiene propiedades como numero_asiento_premium, etc.
                this.asientos_cama = busSeleccionado.numero_asiento_cama;
                this.asientos_semicama = busSeleccionado.numero_asiento_semicama;
                this.asientos_premium = busSeleccionado.numero_asiento_premium;
                this.asientos_mixto = busSeleccionado.numero_asiento_mixto;

                this.respuestas[106].respuesta = this.asientos_cama;
                this.respuestas[116].respuesta = this.asientos_semicama;
                this.respuestas[126].respuesta = this.asientos_premium;
                // Además, establece el tipo de bus, asumiendo que bus tiene una propiedad tipo_bus
                this.tipoBusSeleccionado = busSeleccionado.tipo_bus;
            }
        },*/
        async getChecklist() {
            try {
                if (!this.checklist_id) {
                    return false;
                }
                const {data, status} = await axios.get(`/getchecklistPrevencion/${this.checklist_id}`);

                if (status === 200) {
                    //this.checklist = data
                    console.log(data.BUS_ID); // Para verificar el valor y tipo

                    this.bus_id = data.BUS_ID
                    this.destino_id = data.DESTINO_ID
                    this.servicio = data.TIPO_SERVICIO
                    this.hora_salida = data.HORA_SALIDA
                    this.fecha = data.FECHA
                    this.observaciones = data.OBSERVACIONES
                    this.bus_id = this.id_bus
                }


            } catch (e) {
                console.log(e)
            }
        },
        async getBusesAll() {
            try {
                let url = '/getBusesLista?operador=lista'

                const {data, status} = await axios.get(url)
                if (status === 200) {
                    this.buses = data
                }

            } catch (e) {
                console.log(e)
            }
        },
        async cargarDestinos() {
            await axios.get('/destinos').then(res => {
                this.destinos = res.data
            })
        },
        updateRespuestas(itemId, fieldId, value, imageFile = null) {

            let item = this.respuestas[itemId];
            if (!item) {
                item = {
                    id: itemId,
                    respuesta: value,
                    observaciones: null,
                    image: null
                };

                this.$set(this.respuestas, itemId, item);
            } else {
                item.respuesta = value;
            }
            console.log(this.respuestas)
            if (value === 'NO') {
                item.observaciones = '';
            }
        },

        disablePastDates(date) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            return date < today;
        },
        async submitPage() {

           /* if (this.users.length === 0) {
                await Swal.fire({
                    title: 'Error al enviar el checklist',
                    text: 'No se puede enviar el checklist sin firmas',
                    icon: 'error',
                    confirmButtonText: 'Entendido'
                });
                return;
            }*/

            Swal.fire({
                title: 'Por favor espera...',
                html: 'Creando checklist...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading(); // Muestra el spinner de carga
                },
            });

            let missingItems = [];
            let nonCompliantItems = [];

            // Iterar sobre la lista de elementos del checklist
            this.checklistItems.forEach(checklist => {
                checklist.items.forEach(item => {
                    const respuesta = this.respuestas[item.id];
                    // Verificar si hay una respuesta para el ítem actual
                    if (!respuesta || respuesta.respuesta === null) {
                        missingItems.push(item.name);
                    } else if (respuesta.respuesta === 'NO') {
                        // Si la respuesta es 'NO', verificar si se han especificado asientos no conformes
                        if (!respuesta.respuestas_adicionales || respuesta.respuestas_adicionales.trim() === '') {
                            nonCompliantItems.push(item.name);
                        }
                    }
                });
            });


            if (missingItems.length > 0) {
                await Swal.fire({
                    title: 'Faltan Respuestas en Ítems',
                    text: `Los siguientes ítems están sin respuestas: ${missingItems.join(', ')}`,
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
            }

            /* if (nonCompliantItems.length > 0) {
                 await Swal.fire({
                     title: 'Ítems No Conformes',
                     text: `Los siguientes ítems no son conformes: ${nonCompliantItems.join(', ')}`,
                     icon: 'error',
                     confirmButtonText: 'Entendido'
                 });
             }*/

            if (missingItems.length === 0) {
                let formData = new FormData();

                /*   let data = {
                       'category_id': 1,
                       'bus_id': this.bus_id,
                       'destino_id': this.destino_id,
                       'tipo_servicio': this.servicio,
                       'hora_salida': this.hora_salida,
                       'fecha': this.fecha,
                       'observaciones': this.observaciones,
                       'respuestas': JSON.stringify(this.respuestas)
                   };

                   for (let key in data) {
                       formData.append(key, data[key]);
                   }

                   for (let i = 0; i < Object.keys(this.imagePreviews).length; i++) {
                       let key = Object.keys(this.imagePreviews)[i];
                       let image = this.imagePreviews[key];
                       formData.append('images[]', image);
                   }*/
                // Agregar campos de texto a FormData
                formData.append('category_id', this.category_id);
                formData.append('bus_id', this.bus_id);
                //formData.append('destino_id', this.destino_id);
                //formData.append('tipo_servicio', this.servicio);
                //formData.append('hora_salida', this.hora_salida);
                formData.append('fecha', this.fecha);
                formData.append('kilometraje', this.kilometraje_act);
                formData.append('observaciones', JSON.stringify(this.observaciones));
                formData.append('users', JSON.stringify(this.users));

                // Agregar respuestas (y sus imágenes, si las hay) a FormData
                for (const [key, respuesta] of Object.entries(this.respuestas)) {
                    // Agrega cada propiedad de la respuesta como un campo de texto
                    for (const [propKey, propValue] of Object.entries(respuesta)) {
                        if (propKey !== 'images') {
                            formData.append(`respuestas[${key}][${propKey}]`, propValue);
                        }
                    }

                    // Agregar imagen si está presente
                    if (respuesta.images instanceof File) {
                        formData.append(`respuestas[${key}][images]`, respuesta.images, respuesta.images.name);
                    }
                }

                try {
                    // Determinar la URL basada en si estamos creando un nuevo checklist o editando uno existente
                    const url = this.checklist_id === 0 ? '/checklist-prevencion' : `/checklist-prevencion/${this.checklist_id}`;

                    const {data} = await axios.post(url, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    });
                    Swal.close();
                    await Swal.fire({
                        title: 'Checklist enviado',
                        text: 'El checklist se ha enviado correctamente',
                        icon: 'success',
                        confirmButtonText: 'Entendido'
                    });
                    window.location.href = '/checklist-prevencion';
                } catch (error) {
                    await Swal.fire({
                        title: 'Error al enviar el checklist',
                        text: 'Ha ocurrido un error al enviar el checklist. Por favor, intenta nuevamente',
                        icon: 'error',
                        confirmButtonText: 'Entendido'
                    });
                }

            }
        },
        handleFileUpload(event, itemId) {
            let file = event.target.files[0];
            console.log(file)
            //this.updateRespuestas(itemId, null, null, file);

            // Create an object URL for the file
            let url = URL.createObjectURL(file);
            this.respuestas[itemId].images = file;
            this.$set(this.imagePreviews, itemId, url);
        },
        handleValidation({direction, currentStep}, callback) {
            // Aquí puedes ajustar tu lógica de validación según sea necesario
            console.log(this.checklistItems)
            let isValid = this.validateStep(this.checklistItems);
            callback(isValid);
        },
        getCurrentTime() {
            const now = new Date();
            return `${now.getHours()}:${now.getMinutes()}`;
        },
        timeToMinutes(time) {
            const [hour, minute] = time.split(':').map(Number);
            return hour * 60 + minute;
        },
        formatTime(date) {
            if (!(date instanceof Date) || isNaN(date.getTime())) {
                return 'Invalid Date'; // Retorna esto si `date` no es una fecha válida
            }

            const hours = date.getHours().toString().padStart(2, '0');
            const minutes = date.getMinutes().toString().padStart(2, '0');
            return `${hours}:${minutes}`;
        },
        validateStep(categories) {
            // valida las respuestas de cada categoria

            //bus_id requerido
            if (this.bus_id === 0) {
                Swal.fire({
                    title: 'Faltan Respuestas en Ítems',
                    text: `Debe seleccionar un bus`,
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
                return false;
            }

            //kilometraje_act requerido
            if (this.kilometraje_act === 0) {
                Swal.fire({
                    title: 'Faltan Respuestas en Ítems',
                    text: `Debe ingresar el kilometraje actual`,
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
                return false;
            }


            let missingItems = [];
            let currentCategory = categories.find(category => category.order_type === (this.currentStep));
            console.log(currentCategory)
            if (currentCategory) {
                currentCategory.items.forEach(item => {
                    const respuesta = this.respuestas[item.id];
                    if (!respuesta || respuesta.respuesta === null) {
                        // Agrega el nombre del ítem a la lista de ítems faltantes
                        missingItems.push(item.name);
                    } else if (respuesta.respuesta === 'NO') {
                        // Si la respuesta es 'NO' y el ítem requiere observaciones
                        if (item.is_observations === 'si' && (!respuesta.observaciones || respuesta.observaciones.trim() === '')) {
                            // Agrega el nombre del ítem a la lista de ítems faltantes
                            missingItems.push(item.name);
                        }
                    }
                });
            }
            // Si hay ítems faltantes, muestra una alerta con todos ellos
            if (missingItems.length > 0) {
                Swal.fire({
                    title: 'Faltan Respuestas en Ítems',
                    html: `
                        <ul style="list-style-type: none; padding: 0;">
                            ${missingItems.map(item => `<li style="margin-bottom: 10px; font-size: 16px;">${item}</li>`).join('')}
                        </ul>
                    `,
                    icon: 'warning',
                    confirmButtonText: 'Entendido',
                    customClass: {
                        container: 'my-swal',
                        title: 'my-swal-title',
                        content: 'my-swal-content',
                        confirmButton: 'btn btn-success',
                    }
                });
                return false;
            }
            return true;
        },
        validateTime() {
            const userInput = this.hora_salida;
            const currentTime = new Date();

            // Obtén las horas y minutos de la hora actual
            const currentHours = currentTime.getHours();
            const currentMinutes = currentTime.getMinutes();

            // Formatea la hora actual para compararla
            const formattedCurrentTime = (currentHours < 10 ? '0' : '') + currentHours + ':' + (currentMinutes < 10 ? '0' : '') + currentMinutes;

            // Compara la hora del input con la hora actual
            if (userInput < formattedCurrentTime) {
                Swal.fire({
                    title: 'Hora de salida inválida',
                    text: 'La hora seleccionada es menor que la hora actual.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });

                return false;
            }
            return true;
        },
        addObservacion() {
            this.observaciones.push('');
        },
        removeObservacion(index) {
            this.observaciones.splice(index, 1);
        },
        validatePassword() {
            // Resetear el mensaje de error cada vez que se valida
            this.passwordError = '';

            // Ejemplo de validación: asegurar que las contraseñas coincidan
            if (this.password !== this.password_repeat) {
                this.passwordError = 'Las contraseñas no coinciden.';
            }

            // Aquí puedes agregar más validaciones según necesites
        },
        async addFirmante() {
            const result = await Swal.fire({
                title: 'Confirmar Acción',
                text: '¿Desea firmar o rechazar?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Rechazar'
            });

            if (result.value) {
                try {
                    const trabajadorData = this.trabajadores.find(trabajador => trabajador.id === this.trabajador_id);

                    if (!trabajadorData) {
                        Swal.fire('Error', 'No se encontró el trabajador.', 'error');
                        return;
                    }

                    // Checks if the area already has a signed user
                    const areaHasSignedUser = this.users.some(user => user.area_name === this.areas.find(area => area.id === this.area_id).name && user.firmado === 1);

                    if (areaHasSignedUser) {
                        Swal.fire('Error', 'Ya existe un usuario firmado para esta área.', 'error');
                        return;
                    }

                    if(!this.isAgreeSigned){
                        this.users.push({
                            id: trabajadorData.id,
                            nombre: trabajadorData.name,
                            apellidos: trabajadorData.apellidos,
                            area_name: this.areas.find(area => area.id === this.area_id).name,
                            fecha: this.formatDate(new Date()),
                            observaciones: this.observacion,
                            firmado: 0
                        });

                        this.observacion = '';
                        //se ha negado a firmar
                        Swal.fire('No Firmado', 'La acción ha sido confirmada con éxito.', 'success');

                        return false
                    }

                    // Make the request to the server to validate the password
                    const loginResponse = await axios.post('/firmaLogin', {
                        rut: trabajadorData.rut,
                        password: this.password
                    });

                    if (loginResponse.data.success) {
                        this.users.push({
                            id: trabajadorData.id,
                            nombre: trabajadorData.name,
                            apellidos: trabajadorData.apellidos,
                            area_name: this.areas.find(area => area.id === this.area_id).name,
                            fecha: this.formatDate(new Date()),
                            observaciones: 'firmado',
                            firmado: 1
                        });

                        this.password = '';
                        this.password_repeat = '';
                        this.observacion = '';

                        Swal.fire('Firmado', 'La acción ha sido confirmada con éxito.', 'success');
                    } else {
                        Swal.fire('Error', 'La validación de inicio de sesión falló.', 'error');
                    }
                } catch (error) {
                    console.error('An error occurred during login:', error);
                    Swal.fire('Error', 'Ocurrió un error durante la validación de inicio de sesión.', 'error');
                }
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire('Cancelado', 'La acción ha sido rechazada.', 'info');
            }
        },

        async getTrabajadoresAll() {
            try {
                let url = '/trabajadoresByAreaAll';

                // Concatena con la URL el ID del área si es proporcionado
                if (this.area_id !== 0) {
                    url += '?area_id=' + this.area_id;
                }

                const response = await axios.get(url);
                this.trabajadores = response.data;
            } catch (error) {
                console.error(error);
            }
        },
        goBack() {
            window.location.href = '/checklist-prevencion';
        }
    },
    mounted() {
        this.fetchChecklistData();
        this.getChecklist();
        this.getBusesAll();
        this.cargarDestinos();
    }
}
;
</script>
<style scoped>
.content-item {
    width: 300px !important;
    margin-bottom: 20px;
}

.content-item label {
    font-size: 13px;
    font-weight: 600;
}

.disabled {
    cursor: not-allowed;
    pointer-events: all !important;
}

.my-swal {
    background-color: #f9f9f9;
}

.my-swal-title {
    color: #333;
    font-size: 24px;
}

.my-swal-content {
    color: #666;
}

.my-swal-confirm-button {
    background-color: #3085d6;
    color: #fff;
}

.grid-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* 3 columnas de igual anchura */
    grid-gap: 20px; /* Espacio entre las celdas de la grid */
}

.grid-item {
    /* Estilos adicionales para los elementos de la grid, si es necesario */
}

.grid-item-full {
    grid-column: 1 / -1; /* Hace que las observaciones ocupen todas las columnas */
}

.badge-secondary {
    background-color: #6c757d;
}

.badge-success {
    background-color: #28a745;
}

.badge-warning {
    background-color: #ffc107;
}

.badge-danger {
    background-color: #dc3545;
}

.badge-info {
    background-color: #17a2b8;
}

.vs__dropdown-toggle {
    padding: .775rem 1rem !important;
    font-size: 1rem !important;
}

</style>


