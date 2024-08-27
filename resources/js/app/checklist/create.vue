<template>
    <Stepper :categories="checklistItems" :initialStep="currentStep" :totalSteps="7">

        <template v-for="step in 7">
            <template v-if="step === currentStep" :key="step">
            <form @submit.prevent="submitPage" class="card-body py-20 w-100  px-9">

                <div class="row">
                    <div class="col-md-3">
                        <label class="fs-6 fw-semibold mb-2" for="">Bus</label>
                        <select-2
                            v-model="bus_id"
                            dataType="number"
                            label="Seleccione un bus"
                            class="form-control form-control-solid"
                        >
                            <option
                                v-for="(bus, index) in buses"
                                :key="bus.id"
                                :value="bus.id">
                                {{ bus.numero_bus + ' - ' + bus.patente }}
                            </option>
                        </select-2>
                    </div>

                    <div class="col-md-3">
                        <label class="fs-6 fw-semibold mb-2" for="">Fecha</label>
                        <input type="date" class="form-control form-control-solid">
                    </div>


                </div>


                <div class="w-100">
                    <div class="pb-10 pb-lg-15">
                        <h2 class="fw-bold text-dark">{{ getItemsForCurrentCategory.name }}</h2>
                    </div>


                    <div class="d-flex flex-row flex-wrap">
                        <div class="content-item" v-for="(item, itemKey) in getItemsForCurrentCategory.items" :key="itemKey">
                            <label class="mb-3" :for="`item-${item.id}`">{{ item.name }}</label>
                            <div v-for="(field, fieldKey) in item.fields" :key="fieldKey">
                                <div v-for="(option, optionKey) in parseOptions(field.options)" :key="optionKey">
                                    <label class="form-check form-check-custom form-check-solid mb-2">
                                        <input class="form-check-input" type="radio" :value="option"
                                               :name="`item-${item.id}`"
                                               @change="updateRespuestas(item.id, field.id, option)">
                                        <span class="form-check-label">{{ option }}</span>
                                    </label>
                                </div>
                                <div v-if="item.isChild === 1" class="content-item py-3 px-2">
                                    <input type="text" class="form-control form-control-solid"
                                           v-model="respuestas[item.id].respuestas_adicionales"
                                           :disabled="respuestas[item.id].respuesta !== 'NO'">
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="row">
                    <div class="col-md-5">
                        <label for="">Observaciones</label>
                        <textarea
                            v-model="observaciones"
                            class="form-control form-control-solid">

                        </textarea>
                    </div>
                </div>

                <div class="d-flex flex-stack pt-10">
                    <!--begin::Wrapper-->
                    <div class="mr-2">
                        <button type="button" class="btn btn-lg btn-light-primary me-3"
                                data-kt-stepper-action="previous">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr063.svg-->
                            <span class="svg-icon svg-icon-4 me-1">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
																<rect opacity="0.5" x="6" y="11" width="13" height="2"
                                                                      rx="1" fill="currentColor"/>
																<path
                                                                    d="M8.56569 11.4343L12.75 7.25C13.1642 6.83579 13.1642 6.16421 12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75L5.70711 11.2929C5.31658 11.6834 5.31658 12.3166 5.70711 12.7071L11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25C13.1642 17.8358 13.1642 17.1642 12.75 16.75L8.56569 12.5657C8.25327 12.2533 8.25327 11.7467 8.56569 11.4343Z"
                                                                    fill="currentColor"/>
															</svg>
														</span>
                            <!--end::Svg Icon-->Back
                        </button>
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Wrapper-->
                    <div>
                        <button type="button" class="btn btn-lg btn-primary me-3" data-kt-stepper-action="submit">
															<span class="indicator-label">Submit
                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
															<span class="svg-icon svg-icon-3 ms-2 me-0">
																<svg width="24" height="24" viewBox="0 0 24 24"
                                                                     fill="none" xmlns="http://www.w3.org/2000/svg">
																	<rect opacity="0.5" x="18" y="13" width="13"
                                                                          height="2" rx="1"
                                                                          transform="rotate(-180 18 13)"
                                                                          fill="currentColor"/>
																	<path
                                                                        d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                                        fill="currentColor"/>
																</svg>
															</span>
                                                                <!--end::Svg Icon--></span>
                            <span class="indicator-progress">Please wait...
															<span
                                                                class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <button type="button" class="btn btn-lg btn-primary" @click="stepNext" data-kt-stepper-action="next">Continue
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                            <span class="svg-icon svg-icon-4 ms-1 me-0">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
																<rect opacity="0.5" x="18" y="13" width="13" height="2"
                                                                      rx="1" transform="rotate(-180 18 13)"
                                                                      fill="currentColor"/>
																<path
                                                                    d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                                    fill="currentColor"/>
															</svg>
														</span>
                            <!--end::Svg Icon--></button>
                    </div>
                    <!--end::Wrapper-->
                </div>
            </form>
        </template>
        </template>
    </Stepper>
</template>


<script>

import CardComponent from "../../../components/CardComponent.vue";
import moment from "moment";
import Select2 from "../../../components/Form/Select2.vue";
import Stepper from "../../../components/Stepper.vue";

export default {
    components: {
        Select2,
        CardComponent,
        Stepper
    },
    computed:{
        getItemsForCurrentCategory() {
            let copiaChecklistItems = this.checklistItems;
            return copiaChecklistItems.find(item => item.id === this.currentStep);
        },
    },
    data() {
        return {
            checklistItems: [],
            paginatedItems: [],
            currentPage: 0,
            respuestas: {},
            observaciones: '',
            bus_id: 0,
            buses: [],
            fecha: this.obtenerFechaActual(), // Fecha seleccionada por el usuario
            fechaMinima: this.obtenerFechaActual(), //
            currentStep: 1,
        }
    },/**/
    mounted() {
        this.fetchChecklistData();
        this.getBusesAll();
    },

    methods: {
        obtenerFechaActual() {
            const hoy = new Date();
            const mes = `0${hoy.getMonth() + 1}`.slice(-2); // Asegura dos dígitos
            const dia = `0${hoy.getDate()}`.slice(-2); // Asegura dos dígitos
            return `${hoy.getFullYear()}-${mes}-${dia}`;
        },
        //STEP AUMENTA EN 1 DISMINUYE EN 1 PERO NO MENOR A 1
        stepNext() {
           this.currentStep = this.currentStep + 1;
        },
        stepPrevivus() {
            this.currentStep = this.currentStep + 1;
        },
        async fetchChecklistData() {
            try {
                const {data} = await axios.get('/checklist-structure/1');
                this.checklistItems = data;

                // Construye un nuevo objeto de respuestas basado en los datos obtenidos
                let newRespuestas = {};

                data.forEach(checklist => {

                    checklist.items.forEach(item => {
                        newRespuestas[item.id] = {
                            id: item.id,
                            respuesta: null,
                            respuestas_adicionales: ''
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
        paginateData() {
            // Logic to split `checklistData` into `paginatedItems` based on your pagination rules
        },
        parseOptions(options) {
            return options.split(',');
        },
        getRespuesta(itemId) {
            return this.respuestas[itemId]?.respuesta;
        },
        getRespuestasAdicionales(itemId) {
            return this.respuestas[itemId]?.respuestas_adicionales;
        },

        updateRespuestas(itemId, fieldId, value) {
            // Check if the item already exists in the responses
            let item = this.respuestas[itemId];
            if (!item) {
                // If not, create a new item with the given id and response
                item = {
                    id: itemId,
                    respuesta: value,
                    respuestas_adicionales: null
                };
                this.$set(this.respuestas, itemId, item);
            } else {
                // If it does, just update the response
                item.respuesta = value;
            }
            console.log(this.respuestas)
            // If the response is 'NO', set the additional responses to an empty string
            if (value === 'NO') {
                item.respuestas_adicionales = '';
            }
        },

        async submitPage() {
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

            if (nonCompliantItems.length > 0) {
                await Swal.fire({
                    title: 'Ítems No Conformes',
                    text: `Los siguientes ítems no son conformes: ${nonCompliantItems.join(', ')}`,
                    icon: 'error',
                    confirmButtonText: 'Entendido'
                });
            }

            if (missingItems.length === 0 && nonCompliantItems.length === 0) {
                // Todo está correcto, procede con la acción deseada
                console.log("El formulario está completo, enviar los datos...");
                // Aquí podrías enviar los datos a tu backend, por ejemplo
                // await this.sendFormData();
            }
        },
    }
}

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

.select2-container--default .select2-selection--single .select2-selection__rendered {
    background-color: #fff !important;
    border: 1px solid #ced4da !important;
    border-radius: .25rem !important;
    color: #495057 !important;
    padding: .375rem .75rem !important;
    line-height: 1.5 !important;
    height: calc(1.5em + .75rem + 2px) !important;
}
</style>

