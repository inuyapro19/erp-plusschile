<template>
    <Stepper
        :categories="checklistItems"
        :initialStep="currentStep"
        :totalSteps="totalSteps"
        @step-changed="currentStep = $event.newStep"
        @submit-page="submitPage"
    >

        <template #base>
            <div class="row mb-5">
                <div class="col-md-4">
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

                <div class="col-md-4">
                    <label class="fs-6 fw-semibold mb-2" for="">Fecha</label>
                    <input type="date" v-model="fecha" class="form-control form-control-solid">

                </div>


            </div>
        </template>

        <template #step-1>
            <StepForm
                :respuestas="respuestas"
                :current-category-items="checklistItems.length && checklistItems.find(item=> item.id === 1) ? checklistItems.find(item=> item.id === 1) : {}"
                @updateRespuestas="updateRespuestas"
                @handleFileUpload="handleFileUpload"
                :image-previews="imagePreviews"
            />
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

    </Stepper>
</template>

<script>
import CardComponent from "../../../components/CardComponent.vue";
import Select2 from "../../../components/Form/Select2.vue";
import Stepper from "../../../components/Stepper.vue";
import StepForm from "./StepForm.vue";
// Importa otros componentes necesarios...
//cambiar por componentes dinamicos
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/es';
export default {
    components: {
        StepForm,
        Select2,
        CardComponent,
        Stepper,
        DatePicker
    },
    computed: {

        currentCategoryItems() {
            let copiaChecklistItems = this.checklistItems;
            console.log(copiaChecklistItems)
            let items = copiaChecklistItems.find(item => item.id === this.currentStep);
            console.log(items)
            return items;
        },
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
            fecha:'', // Fecha seleccionada por el usuario
            fechaMinima: '', //
            totalSteps: 8,
            imagePreviews: {}
        };
    },
    methods: {

        parseOptions(options) {
            return options.split(',');
        },
        obtenerFechaActual() {
            const hoy = new Date();
            const mes = `0${hoy.getMonth() + 1}`.slice(-2); // Asegura dos dígitos
            const dia = `0${hoy.getDate()}`.slice(-2); // Asegura dos dígitos
            return `${hoy.getFullYear()}-${mes}-${dia}`;
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
                            observaciones: '',
                            images:null
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
        updateRespuestas(itemId, fieldId, value,imageFile = null) {
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

            console.log(this.currentStep)

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

                formData.append('category_id', 1);

                formData.append('bus_id', this.bus_id);
                formData.append('fecha', this.fecha);

                formData.append('observaciones', this.observaciones);

                formData.append('respuestas', JSON.stringify(this.respuestas));

                for (let i = 0; i < Object.keys(this.imagePreviews).length; i++) {
                    let key = Object.keys(this.imagePreviews)[i];
                    let image = this.imagePreviews[key];
                    formData.append('images[]', image);
                }

                try {
                    const {data} = await axios.post('/checklist-calidad', formData);

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
            this.updateRespuestas(itemId, null, null, file);

            // Create an object URL for the file
            let url = URL.createObjectURL(file);
            this.$set(this.imagePreviews, itemId, url);
        },
    },
    mounted() {
        this.fetchChecklistData();
        this.getBusesAll();
    }
};
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
</style>


