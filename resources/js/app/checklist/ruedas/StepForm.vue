<template>

    <div data-kt-stepper-element="content" class="current">


        <!-- Contenido dinámico basado en la categoría actual -->
        <div>
            <h2 class="fw-bold text-dark">{{ currentCategoryItems.name }}</h2>
            <div class="d-flex flex-row flex-wrap justify-content-between">
                <!-- Itera sobre los items de la categoría actual -->
                <div class="content-item" v-for="(item, itemKey) in currentCategoryItems.items"
                     :key="itemKey">
                    <label class="mb-3" :for="`item-${item.id}`">{{ item.name }}</label>
                    <div v-for="(field, fieldKey) in item.fields" :key="fieldKey">
                        <div v-for="(option, optionKey) in parseOptions(field.options)"
                             :key="optionKey">
                            <label class="form-check form-check-custom form-check-solid mb-2">
                                <input class="form-check-input" type="radio" :value="option"
                                       v-model="respuestas[item.id].respuesta"
                                       :name="`item-${item.id}-${currentCategoryItems.id}`"
                                       @change="updateRespuestas(item.id, field.id, option)">
                                <span class="form-check-label">{{ option }}</span>
                            </label>
                        </div>
                        <div  class="content-item py-3 px-2">
                            <input type="text" class="form-control form-control-solid"
                                   v-model="respuestas[item.id].observaciones"
                                   :disabled="respuestas[item.id].respuesta !== 'NO'">

                            <input type="file" class="form-control form-control-solid mt-2"
                                   @change="handleFileUpload($event, item.id)"
                                   :disabled="respuestas[item.id].respuesta !== 'NO'">
                            <img
                                class="mt-2"
                                width="100px"
                                v-if="imagePreviews[item.id]"
                                :src="imagePreviews[item.id]"
                                alt="Image preview">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        currentCategoryItems: {
            type: Object,
            required: true
        },
        respuestas: {
            type: Object,
            required: true
        },
        imagePreviews: {
            type: Object,
            required: true
        }
    },
    methods: {
        parseOptions(options) {
            return options.split(',');
        },
        updateRespuestas(itemId, fieldId, option) {
            this.$emit('updateRespuestas', itemId, fieldId, option);
        },
        handleFileUpload(event, itemId) {
            this.$emit('handleFileUpload', event, itemId);
        }

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
</style>
