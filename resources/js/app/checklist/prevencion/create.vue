<template>
    <Stepper
        :categories="checklistItems"
        :initialStep="currentStep"
        :totalSteps="totalSteps"
        @step-changed="currentStep = $event.newStep"
        @request-validate="handleValidation"
        @go-back="goBack"
        @submit-page="submitPage"
        @clear-form="clearForm"
    >

        <template>
            <div v-for="(step,index) in componentePrevencion"
                 v-if="currentStep === (index + 1)"
                 :key="step.id">
                <component
                    :is="step.component"
                    v-bind="step.props"
                    v-on="step.events"
                    :bus_id="bus_id"
                    v-show="step.visible"
                />
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
import baseStep from "./components/base.vue";
import ObsercacionesStep from "./components/Observaciones.vue";
import ResumenStep from "./components/Resumen.vue";
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
        DataTable,
        baseStep,
        ObsercacionesStep,
        ResumenStep
    },
    computed: {

        currentCategoryItems() {
            let copiaChecklistItems = this.checklistItems;
            console.log(copiaChecklistItems)
            let items = copiaChecklistItems.find(item => item.id === this.currentStep);
            console.log(items)
            return items;
        },

        formattedBuses() {
            return this.buses.map(bus => ({
                id: bus.id,
                label: bus.numero_bus + ' - ' + bus.patente
            }));
        },
        componentePrevencion() {
            const steps = [{
                id: 12,
                name: 'Inicio',
                component: 'baseStep',
                visible: true,
                props: {
                    isEdit: this.isEdit,
                    bus_id: this.bus_id,
                    buses: this.buses,
                    fecha: this.fecha,
                    modelo: this.modelo,
                    marca: this.marca,
                    isProgramacion: this.isProgramacion,
                    hora_salida: this.hora_salida,
                    servicio: this.servicio,
                    servicios: this.servicios,
                    origen_id: this.origen_id,
                    destino_id: this.destino_id,
                    destinos: this.destinos,
                    numero_pisos: this.numero_pisos,
                    kilometraje_ant: this.kilometraje_ant,
                    kilometraje_act: this.kilometraje_act,
                    kilometrajeError: this.kilometrajeError,

                },
                events: {
                    /*obtenerAsientosYTipo: this.obtenerAsientosYTipo,
                    getAllItemReported: this.getAllItemReported,*/
                    getRevisionData: this.fetchBusRevisionData,
                    fetchChecklistData: this.getChecklist,
                    update: this.handleUpdate
                }
            },
               {
                      id: 13,
                      name: 'Cabina',
                      component: 'StepForm',
                      visible: true,
                      props: {
                          respuestas: this.respuestas,
                          currentCategoryItems: this.checklistItems.length && this.checklistItems.find(item => item.id === 13) ? this.checklistItems.find(item => item.id === 13) : {},
                          imagePreviews: this.imagePreviews,
                           buses: this.buses,
                        bus_id: this.bus_id,
                        fecha: this.fecha,

                      },
                      events: {
                          updateRespuestas: this.updateRespuestas,
                          handleFileUpload: this.handleFileUpload
                      }
                  },
                {
                    id: 14,
                    name: 'Cabina',
                    component: 'StepForm',
                    visible: true,
                    props: {
                        respuestas: this.respuestas,
                        currentCategoryItems: this.checklistItems.length && this.checklistItems.find(item => item.id === 14) ? this.checklistItems.find(item => item.id === 14) : {},
                        imagePreviews: this.imagePreviews,
                        buses: this.buses,
                        bus_id: this.bus_id,
                        fecha: this.fecha,

                    },
                    events: {
                        updateRespuestas: this.updateRespuestas,
                        handleFileUpload: this.handleFileUpload
                    }
                },
                {
                    id: 15,
                    name: 'Cabina',
                    component: 'StepForm',
                    visible: true,
                    props: {
                        respuestas: this.respuestas,
                        currentCategoryItems: this.checklistItems.length && this.checklistItems.find(item => item.id === 15) ? this.checklistItems.find(item => item.id === 15) : {},
                        imagePreviews: this.imagePreviews,
                        buses: this.buses,
                        bus_id: this.bus_id,
                        fecha: this.fecha,

                    },
                    events: {
                        updateRespuestas: this.updateRespuestas,
                        handleFileUpload: this.handleFileUpload
                    }
                },
                {
                    id: 16,
                    name: 'Cabina',
                    component: 'StepForm',
                    visible: true,
                    props: {
                        respuestas: this.respuestas,
                        currentCategoryItems: this.checklistItems.length && this.checklistItems.find(item => item.id === 16) ? this.checklistItems.find(item => item.id === 16) : {},
                        imagePreviews: this.imagePreviews,
                        buses: this.buses,
                        bus_id: this.bus_id,
                        fecha: this.fecha,

                    },
                    events: {
                        updateRespuestas: this.updateRespuestas,
                        handleFileUpload: this.handleFileUpload
                    }
                },
                {
                    id: 17,
                    name: 'SALON PISO 1',
                    component: 'StepForm',
                    visible: true,
                    props: {
                        respuestas: this.respuestas,
                        currentCategoryItems: this.checklistItems.length && this.checklistItems.find(item => item.id === 17) ? this.checklistItems.find(item => item.id === 17) : {},
                        imagePreviews: this.imagePreviews,
                        buses: this.buses,
                        bus_id: this.bus_id,
                        fecha: this.fecha,

                    },
                    events: {
                        updateRespuestas: this.updateRespuestas,
                        handleFileUpload: this.handleFileUpload
                    }
                },
                {
                    id: 18,
                    name: 'INTERSALON',
                    component: 'StepForm',
                    visible: true,
                    props: {
                        respuestas: this.respuestas,
                        currentCategoryItems: this.checklistItems.length && this.checklistItems.find(item => item.id === 18) ? this.checklistItems.find(item => item.id === 18) : {},
                        imagePreviews: this.imagePreviews,
                        buses: this.buses,
                        bus_id: this.bus_id,
                        fecha: this.fecha,

                    },
                    events: {
                        updateRespuestas: this.updateRespuestas,
                        handleFileUpload: this.handleFileUpload
                    }
                },
                {
                    id: 19,
                    name: 'SALON PISO 2',
                    component: 'StepForm',
                    visible: true,
                    props: {
                        respuestas: this.respuestas,
                        currentCategoryItems: this.checklistItems.length && this.checklistItems.find(item => item.id === 19) ? this.checklistItems.find(item => item.id === 19) : {},
                        imagePreviews: this.imagePreviews,
                        buses: this.buses,
                        bus_id: this.bus_id,
                        fecha: this.fecha,

                    },
                    events: {
                        updateRespuestas: this.updateRespuestas,
                        handleFileUpload: this.handleFileUpload
                    }
                },
                {
                    id: 20,
                    name: 'BAÑO',
                    component: 'StepForm',
                    visible: true,
                    props: {
                        respuestas: this.respuestas,
                        currentCategoryItems: this.checklistItems.length && this.checklistItems.find(item => item.id === 20) ? this.checklistItems.find(item => item.id === 20) : {},
                        imagePreviews: this.imagePreviews,
                        buses: this.buses,
                        bus_id: this.bus_id,
                        fecha: this.fecha,

                    },
                    events: {
                        updateRespuestas: this.updateRespuestas,
                        handleFileUpload: this.handleFileUpload
                    }
                },
                {
                    id: 21,
                    name: 'Cabina',
                    component: 'StepForm',
                    visible: true,
                    props: {
                        respuestas: this.respuestas,
                        currentCategoryItems: this.checklistItems.length && this.checklistItems.find(item => item.id === 21) ? this.checklistItems.find(item => item.id === 21) : {},
                        imagePreviews: this.imagePreviews,
                        buses: this.buses,
                        bus_id: this.bus_id,
                        fecha: this.fecha,

                    },
                    events: {
                        updateRespuestas: this.updateRespuestas,
                        handleFileUpload: this.handleFileUpload
                    }
                },
                {
                    id: 22,
                    name: 'Cabina',
                    component: 'StepForm',
                    visible: true,
                    props: {
                        respuestas: this.respuestas,
                        currentCategoryItems: this.checklistItems.length && this.checklistItems.find(item => item.id === 22) ? this.checklistItems.find(item => item.id === 22) : {},
                        imagePreviews: this.imagePreviews,
                        buses: this.buses,
                        bus_id: this.bus_id,
                        fecha: this.fecha,

                    },
                    events: {
                        updateRespuestas: this.updateRespuestas,
                        handleFileUpload: this.handleFileUpload
                    }
                },
                {
                    id: 23,
                    name: 'Observaciones',
                    component: 'ObsercacionesStep',
                    visible: true,
                    props: {
                        isEdit: this.isEdit,
                        observaciones: this.observaciones
                    },
                    events: {
                        update: this.handleUpdate
                    }
                },
                {
                    id: 24,
                    name: 'Resumen',
                    component: 'ResumenStep',
                    visible: true,
                    props: {
                        isEdit: this.isEdit,
                        bus_id: this.bus_id,
                        buses: this.buses,
                        fecha: this.fecha,
                        modelo: this.modelo,
                        marca: this.marca,
                        isProgramacion: this.isProgramacion,
                        hora_salida: this.hora_salida,
                        servicio: this.servicio,
                        servicios: this.servicios,
                        origen_id: this.origen_id,
                        destino_id: this.destino_id,
                        destinos: this.destinos,
                        numero_pisos: this.numero_pisos,
                        respuestas: this.respuestas,
                        observaciones: this.observaciones,
                        users: this.users,
                        imagePreviews: this.imagePreviews,
                        trabajadores: this.trabajadores,
                        trabajador_id: this.trabajador_id,
                        password: this.password,
                        password_repeat: this.password_repeat,
                        showPassword: this.showPassword,
                        isAgreeSigned: this.isAgreeSigned,
                        observacion: this.observacion,
                        passwordError: this.passwordError,
                        itemResidencias: this.itemResidencias,
                        columnas: this.columnas,
                        columns: this.columns,
                        areas: this.areas,
                        area_id: this.area_id,
                    },
                    events: {
                        addFirmante: this.addFirmante,
                        update: this.handleUpdate,
                    }
                },

            ];

            return steps.filter(step => this.activeSteps.includes(step.id));
        },

    },
    data() {
        return {
            currentStep: 1,
            activeSteps: [12,13,14,15,16,17,18,19,20,21,22,23,24],
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
            numero_pisos: 2,
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
        },
        numero_pisos(newVal) {
            if (newVal === 1) {
                this.checklistItems = this.checklistItems.filter(item => item.id !== 18 && item.id !== 19);
                this.totalSteps = this.checklistItems.length;
                this.activeSteps = this.activeSteps.filter(step => step !== 18 && step !== 19);
            } else {
                this.fetchChecklistData()

                this.activeSteps.push(18,19)
            }
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
        handleUpdate(eventPayload) {
            this[eventPayload.prop] = eventPayload.value;
            // console.log(this[eventPayload.prop])
        },
        async fetchChecklistData() {
            try {
                // Determina la URL basada en si es una edición y el ID del checklist
                let url = this.checklist_id ? `/checklist-structure-prevencion/2?checklist_id=${this.checklist_id}` : '/checklist-structure-prevencion/2';
                if (this.checklist_id) {
                    this.isEdit = true;
                }

                const {data} = await axios.get(url);
                //console.log(data)
                this.checklistItems = data;
                this.totalSteps = data.length;

                const savedRespuestas = localStorage.getItem('respuestas');
                if (savedRespuestas) {
                    // Si hay respuestas guardadas en localStorage, úsalas
                    this.respuestas = JSON.parse(savedRespuestas);

                    // Puedes decidir cargar o no los datos relacionados con checklistItems,
                    // dependiendo de si los necesitas para otras partes de tu aplicación
                } else {
                    // Si no hay respuestas en localStorage, carga los datos desde la API


                    let newRespuestas = {};
                    const processItems = (items) => {
                        items.forEach(item => {
                            const area = this.areas.find(area => area.id === item.area_id);
                            const areaName = area ? area.name : 'Area desconocida';
                            newRespuestas[item.id] = {
                                id: item.id,
                                name: item.name,
                                respuesta: item.responses ? item.responses[0].respuesta : null,
                                valor: item.responses ? item.responses[0].valor : null,
                                observaciones: item.responses ? item.responses[0].observaciones : '',
                                respuesta_add: item.responses ? item.responses[0].respuesta_add : '',
                                images: item.responses ? item.responses[0].images : null,
                                critical: item.critical,
                                isConteo: item.is_conteo === 'si',
                                area_id: item.area_id ? item.area_id : null,
                                area_name: areaName
                            };

                            if (item.children && item.children.length) {
                                processItems(item.children);
                            }
                        });
                    };

                    data.forEach(checklist => {
                        processItems(checklist.items);
                    });

                    this.respuestas = newRespuestas;

                    // Guarda las nuevas respuestas en localStorage para futuras cargas
                    localStorage.setItem('respuestas', JSON.stringify(newRespuestas));
                }

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
            //agregar al localstorage
            localStorage.setItem('respuestas', JSON.stringify(this.respuestas));
            //step actual al localstorage
            localStorage.setItem('currentStep', this.currentStep);

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

                const areasConIncidenciasIds = Object.values(this.respuestas).reduce((acc, item) => {
                    if ((item.respuesta === 'NO' || item.valor === 'NO') && !acc.includes(item.area_id)) {
                        acc.push(item.area_id);
                    }
                    return acc;
                }, []);

                let cantidad_areas =  this.areas.filter(area => areasConIncidenciasIds.includes(area.id));
                // Agregar campos de texto a FormData
                formData.append('category_id', this.category_id);
                formData.append('bus_id', this.bus_id);

                formData.append('fecha', this.fecha);
                formData.append('kilometraje', this.kilometraje_act);
                formData.append('observaciones', JSON.stringify(this.observaciones));
                formData.append('users', JSON.stringify(this.users));
                formData.append('cantidad_areas',cantidad_areas.length);
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
                    localStorage.removeItem('respuestas');
                    localStorage.removeItem('currentStep');
                    localStorage.removeItem('users');
                    localStorage.removeItem('bus_id');
                    localStorage.removeItem('fecha');
                    localStorage.removeItem('modelo');
                    localStorage.removeItem('marca');
                    localStorage.removeItem('kilometraje_ant');
                    localStorage.removeItem('kilometraje_act');
                    localStorage.removeItem('observaciones');

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
        },
        clearForm() {
            this.bus_id = 0;
            this.fecha = this.formatDate(new Date());
            this.kilometraje_ant = 0;
            this.kilometraje_act = 0;
            this.marca = '';
            this.modelo = '';
            this.observaciones = [];
            this.respuestas = {};
            this.users = [];
            this.trabajadores = [];
            this.trabajador_id = 0;
            this.password = '';
            this.password_repeat = '';
            this.showPassword = false;
            this.isAgreeSigned = true;
            this.observacion = '';
            this.passwordError = '';
            this.itemResidencias = [];
            this.area_id = 0;
            this.numero_pisos = 2;
            this.fetchChecklistData()
        },
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


