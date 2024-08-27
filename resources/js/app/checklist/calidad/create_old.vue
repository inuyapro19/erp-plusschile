<template>
    <Stepper
        :categories="checklistItems"
        :initialStep="currentStep"
        :totalSteps="totalSteps"
        @step-changed="currentStep = $event.newStep"
        @request-validate="handleValidation"
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

                <div class="col-md-5">
                    <label for="tiene_discapacidad" class="fs-6 fw-semibold mb-2">¿Viaje sin programación?</label>
                    <div class="form-check form-switch form-check-custom form-check-solid">
                        <input class="form-check-input"
                               type="checkbox"
                               id="tiene_discapacidad"
                               v-model="isProgramacion"


                        />
                        <label class="form-check-label fw-semibold text-gray-400 ms-3" for="status"></label>
                    </div>
                </div>

                <div class="col-md-5 mb-5">
                    <label class="fs-6 fw-semibold mb-2" for="">Hora de salida</label>
                    <input type="time"
                           v-model="hora_salida"
                           class="form-control form-control-solid disabled"
                           :disabled="isEdit || isProgramacion" >

                </div>
                <div class="col-md-5 mb-5">
                    <label class="fs-6 fw-semibold mb-2" for="">Tipo de servicio</label>
                    <select
                        class="form-select form-select-solid"
                        v-model="servicio"
                        :disabled="isEdit || isProgramacion" >
                    >
                        <option v-for="servicio in servicios" :value="servicio">
                            {{ servicio }}
                        </option>
                    </select>
                </div>
                <div class="col-md-5 mb-5">
                    <label class="fs-6 fw-semibold mb-2" for="">Destinos</label>
                    <select
                        class="form-select form-select-solid"
                        v-model="destino_id"
                        :disabled="isEdit || isProgramacion" >
                    >
                        <option v-for="destino in destinos" :value="destino.id">
                            {{ destino.ciudad }}
                        </option>
                    </select>
                </div>
            </div>
        </template>

        <template #step-2>
            <StepForm
                :respuestas="respuestas"
                :current-category-items="checklistItems.length && checklistItems.find(item=> item.id === 2) ? checklistItems.find(item=> item.id === 2) : {}"
                @updateRespuestas="updateRespuestas"
                @handleFileUpload="handleFileUpload"
                :image-previews="imagePreviews"
            />
        </template>

        <template #step-3>
            <StepForm
                :respuestas="respuestas"
                :current-category-items="checklistItems.length && checklistItems.find(item=> item.id === 3) ? checklistItems.find(item=> item.id === 3) : {}"
                @updateRespuestas="updateRespuestas"
                @handleFileUpload="handleFileUpload"
                :image-previews="imagePreviews"
            />
        </template>

        <template #step-4>
            <StepForm
                :respuestas="respuestas"
                :current-category-items="checklistItems.length && checklistItems.find(item=> item.id === 4) ? checklistItems.find(item=> item.id === 4) : {}"
                @updateRespuestas="updateRespuestas"
                @handleFileUpload="handleFileUpload"
                :image-previews="imagePreviews"
            />
        </template>

        <template #step-5>
            <StepForm
                :respuestas="respuestas"
                :current-category-items="checklistItems.length && checklistItems.find(item=> item.id === 5) ? checklistItems.find(item=> item.id === 5) : {}"
                @updateRespuestas="updateRespuestas"
                @handleFileUpload="handleFileUpload"
                :image-previews="imagePreviews"
            />
        </template>

        <template #step-6>
            <StepForm
                :respuestas="respuestas"
                :current-category-items="checklistItems.length && checklistItems.find(item=> item.id === 6) ? checklistItems.find(item=> item.id === 6) : {}"
                @updateRespuestas="updateRespuestas"
                @handleFileUpload="handleFileUpload"
                :image-previews="imagePreviews"

            />
        </template>

        <template #step-7>
            <StepForm
                :respuestas="respuestas"
                :current-category-items="checklistItems.length && checklistItems.find(item=> item.id === 7) ? checklistItems.find(item=> item.id === 7) : {}"
                @updateRespuestas="updateRespuestas"
                @handleFileUpload="handleFileUpload"
                :image-previews="imagePreviews"
            />
        </template>
        <template #step-8>
            <StepForm
                :respuestas="respuestas"
                :current-category-items="checklistItems.length && checklistItems.find(item=> item.id === 8) ? checklistItems.find(item=> item.id === 8) : {}"
                @updateRespuestas="updateRespuestas"
                @handleFileUpload="handleFileUpload"
                :image-previews="imagePreviews"
            />
        </template>
        <template #step-9>
            <StepForm
                :respuestas="respuestas"
                :current-category-items="checklistItems.length && checklistItems.find(item=> item.id === 9) ? checklistItems.find(item=> item.id === 9) : {}"
                @updateRespuestas="updateRespuestas"
                @handleFileUpload="handleFileUpload"
                :image-previews="imagePreviews"
            />
        </template>
        <template #step-10>
            <StepForm
                :respuestas="respuestas"
                :current-category-items="checklistItems.length && checklistItems.find(item=> item.id === 13) ? checklistItems.find(item=> item.id === 13) : {}"
                @updateRespuestas="updateRespuestas"
                @handleFileUpload="handleFileUpload"
                :image-previews="imagePreviews"
            />
        </template>
        <template #step-11>
            <StepForm
                :respuestas="respuestas"
                :current-category-items="checklistItems.length && checklistItems.find(item=> item.id === 10) ? checklistItems.find(item=> item.id === 10) : {}"
                @updateRespuestas="updateRespuestas"
                @handleFileUpload="handleFileUpload"
                :image-previews="imagePreviews"
            />
        </template>
        <template #step-12>
            <div class="row">
                <div class="col-md-12">
                    <label class="fs-6 fw-semibold mb-2" for="">Observaciones</label>
                    <textarea
                        v-model="observaciones"
                        class="form-control form-control-solid">

                        </textarea>
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
                    <div class="grid-item">
                        <p>Tipo de servicio: {{ servicio }}</p>
                    </div>
                    <div class="grid-item">
                        <p>Destino: {{ destinoCiudad }}</p>
                    </div>
                    <div class="grid-item">
                        <p>Hora de salida: {{ hora_salida }}</p>
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
                            <th>Resultado</th>
                        </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                        <tr v-for="item in respuestasAprobadasConObservaciones" :key="item.id">
                            <td>{{ item.id }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ item.respuesta }}</td>
                            <td>{{ item.observaciones }}</td>
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
                            <th>Resultado</th>
                        </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                        <tr v-for="item in respuestasRechazadas" :key="item.id">
                            <td>{{ item.id }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ item.respuesta }}</td>
                            <td>{{ item.respuesta_add }}</td>
                        </tr>
                        </tbody>
                    </table>
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
        SelectCustom
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
            return Object.values(this.respuestas).filter(item => item.respuesta === 'NO' && item.critical === 'approved with observation').length;
        },

        cantidadRechazados() {
            // Filtra las respuestas con 'NO' y 'critical' igual a 'refused'.
            return Object.values(this.respuestas).filter(item => item.respuesta === 'NO' && item.critical === 'refused').length;
        },

        cantidadNA() {
            return Object.values(this.respuestas).filter(item => item.respuesta === 'NA').length;
        },
        //devuelve solo la rechazadas para el resumen
        respuestasRechazadas() {
            // Filtra y retorna respuestas 'NO' con 'critical' igual a 'refused'.
            return Object.values(this.respuestas).filter(item => item.respuesta === 'NO' && item.critical === 'refused');
        },
        //devuelve las aprobadas con observaciones para el resumen
        respuestasAprobadasConObservaciones() {
            // Filtra y retorna respuestas 'NO' con 'critical' igual a 'approved with observation'.
            return Object.values(this.respuestas).filter(item => item.respuesta === 'NO' && item.critical === 'approved with observation');
        },
        formattedBuses() {
            return this.buses.map(bus => ({
                id: bus.id,
                label: bus.numero_bus + ' - ' + bus.patente
            }));
        }
    },
    data() {
        return {
            currentStep: 1,
            checklistItems: [],
            currentPage: 0,
            respuestas: {},
            observaciones: '',
            bus_id: 0,
            buses: [],
            fecha: this.formatDate(new Date()),// Fecha seleccionada por el usuario
            fechaMinima: '', //
            totalSteps: 0,
            imagePreviews: {},
            destinos: [],
            destino_id: 1,
            servicio: 'SERVICIO EN LINEA',
            servicios: ['SERVICIO EN LINEA', 'SERVICIO EN MINERIA','SIN PROGRAMACION'],
            validate_success: false,
            hora_salida: '',
            category_id: 1,
            isEdit: false,
            isProgramacion: false,
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

        };
    },
    watch: {
        // Observa los cambios en isProgramacion
        isProgramacion(newVal) {
            if (newVal) {
                // Si el checkbox no está marcado, ajusta los valores
                this.hora_salida = '00:00'; // Setea la hora de salida a 00:00
                this.servicio = 'SIN PROGRAMACION'; // Setea el servicio a SIN PROGRAMACION
                this.destino_id = 13; // Setea el destino_id a 13
            } else {
                // Si el checkbox está marcado, puedes ajustar los valores a otros estados iniciales si es necesario
                // Por ejemplo, resetear a valores por defecto o dejarlos vacíos
                this.hora_salida = ''; // Resetear o ajustar según necesidad
                this.servicio = ''; // Resetear o ajustar según necesidad
                this.destino_id = null; // Resetear o ajustar según necesidad
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
        async fetchChecklistData() {
            try {
                //necesito rescatar el ID TERCERA POSICION AÑADOR EL QUERY STRING SOLO SI ES EDITAR  'checklist_id');

                let url = this.checklist_id ? `/checklist-structure/1?checklist_id=${this.checklist_id}` : '/checklist-structure/1';

                //traer los datos de la checklist
                if (this.checklist_id) {
                    this.isEdit = true;
                }

                const {data} = await axios.get(url);
                this.checklistItems = data;
                this.totalSteps = data.length;
                // Construye un nuevo objeto de respuestas basado en los datos obtenidos
                let newRespuestas = {};

                /* data.forEach(checklist => {
                     checklist.items.forEach(item => {
                         newRespuestas[item.id] = {
                             id: item.id,
                             name: item.name,
                             respuesta: null,
                             observaciones: '',
                             respuesta_add: '',
                             images: null
                         };
                     });
                 });*/
                data.forEach(checklist => {
                    checklist.items.forEach(item => {
                        newRespuestas[item.id] = {
                            id: item.id,
                            name: item.name,
                            respuesta: item.responses ? item.responses[0].respuesta : null,
                            observaciones: item.responses ? item.responses[0].observaciones : '',
                            respuesta_add: item.responses ? item.responses[0].respuesta_add : '',
                            images: item.responses ? item.responses[0].images : null,
                            critical: item.critical //'approved with observation', 'refused'
                        };
                    });
                });
                // Asigna el nuevo objeto de respuestas a la propiedad de datos del componente
                this.respuestas = newRespuestas;
            } catch (error) {
                console.error('Error fetching checklist data:', error);
                // Maneja el error como consideres apropiado


            }
        },
        async getChecklist() {
            try {
                if (!this.checklist_id) {
                    return false;
                }
                const {data, status} = await axios.get(`/getchecklistcalidad/${this.checklist_id}`);

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
            // Check if the item already exists in the responses
            console.log(itemId, fieldId, value)
            let item = this.respuestas[itemId];
            if (!item) {
                // If not, create a new item with the given id and response
                item = {
                    id: itemId,
                    respuesta: value,
                    observaciones: null,
                    image: null
                };
                this.$set(this.respuestas, itemId, item);
            } else {
                // If it does, just update the response
                item.respuesta = value;
            }
            console.log(this.respuestas)
            // If the response is 'NO', set the additional responses to an empty string
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
                formData.append('destino_id', this.destino_id);
                formData.append('tipo_servicio', this.servicio);
                formData.append('hora_salida', this.hora_salida);
                formData.append('fecha', this.fecha);
                formData.append('observaciones', this.observaciones);

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
                    const url = this.checklist_id === 0 ? '/checklist-calidad' : `/checklist-calidad/${this.checklist_id}`;

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
                    window.location.href = '/checklist-calidad';
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

            // Validación de la hora de salida
            if (!this.hora_salida) {
                Swal.fire({
                    title: 'Información Incompleta',
                    text: 'Debe seleccionar la hora de salida.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
                return;
            }





            console.log(this.currentStep)
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
                        // Si la respuesta es 'NO', verificar si se han especificado asientos no conformes
                        if (!respuesta.observaciones || respuesta.observaciones.trim() === '') {
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


