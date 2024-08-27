<template>
    <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid gap-10"
         id="kt_create_account_stepper">
        <!-- Navegación del Stepper -->
        <div
            class="card d-flex justify-content-center justify-content-xl-start flex-row-auto w-100 w-xl-300px w-xxl-400px">
            <div class="card-body px-6 px-lg-10 px-xxl-15 py-20">
                <div class="stepper-nav">
                    <div class="stepper-item"
                         :class="{ 'current': index + 1 === currentStep, 'pending': index + 1 !== currentStep}"
                         v-for="(category, index) in categories"
                         :key="category.id"
                        >
                        <div class="stepper-wrapper">
                            <div class="stepper-icon w-40px h-40px">
                                <i class="stepper-check fas fa-check"></i>
                                <span class="stepper-number">{{ index + 1 }}</span>
                            </div>
                            <div class="stepper-label">
                                <h3 class="stepper-title">{{ category.name }}</h3>
                            </div>
                        </div>
                        <div class="stepper-line h-40px"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenido de los Pasos -->
        <div class="card d-flex flex-row-fluid flex-center">
            <form @submit.prevent="submitPage" class="card-body py-20 w-100 px-9">
                <slot name="base" v-if="currentStep === 1"></slot>
                <transition name="fade" mode="out-in">
                    <slot :name="'step-' + currentStep"></slot>
                </transition>
                <slot name="resumen" v-if="currentStep === 10"></slot>
                <div class="d-flex flex-stack pt-10">
                    <!-- Botón Volver: Se muestra solo si currentStep es igual a 1 -->
                    <button type="button" class="btn btn-lg btn-light-primary me-3"
                            v-if="currentStep === 1"
                            @click="goBack">
                        Volver
                    </button>

                    <!-- Botón Anterior: Se muestra si currentStep es mayor a 1 -->
                    <button type="button" class="btn btn-lg btn-light-primary me-3"
                            v-if="currentStep > 1"
                            @click="navigateStepper('previous')">
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
                        Anterior
                    </button>

                    <!-- Botón Siguiente: Se muestra si currentStep es menor a 8 -->
                    <button type="button" class="btn btn-lg btn-primary"
                            v-if="currentStep < totalSteps"
                            @click="navigateStepper('next')">Siguiente
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
                    </button>

                    <!-- Botón Finalizar: Se muestra si currentStep es igual a 8 -->
                    <button type="button" class="btn btn-lg btn-primary"
                           v-else
                            @click="submitPage"
                           >
                        Finalizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        initialStep: {
            type: Number,
            default: 1
        },
        totalSteps: {
            type: Number,
            required: true
        },
        categories: {
            type: Array,
            required: true,
            validator(value) {
                // Valida que cada categoría tenga un id y un nombre
                return value.every(category => category.id && category.name);
            }
        },

    },
    data() {
        return {
            currentStep: this.initialStep,
        }
    },
    watch: {
        currentStep(newStep, oldStep) {
            if (newStep < 1) {
                this.currentStep = 1;
            } else if (newStep > this.totalSteps) {
                this.currentStep = this.totalSteps;
            } else {
                this.$emit('step-changed', {newStep, oldStep});
            }
        },
    },
    methods: {
        goToStep(step) {
            if (step >= 1 && step <= this.totalSteps) {
                this.currentStep = step;
            }
        },
        navigateStepper(direction) {
            if (direction === 'next' && this.currentStep < this.totalSteps) {
                // Emitir evento de validación antes de avanzar al siguiente paso
                this.$emit('request-validate', { direction: 'next', currentStep: this.currentStep }, (isValid) => {
                    if (isValid) {
                        this.currentStep++;
                        if (this.currentStep <= this.totalSteps) {
                            this.$emit('step-changed', this.currentStep);
                        }
                    }
                });
            } else if (direction === 'previous' && this.currentStep > 1) {
                this.currentStep--;
                this.$emit('step-changed', this.currentStep);
            }
        },

        /*  navigateStepper(direction) {
              if (direction === 'next' && this.currentStep < this.totalSteps) {
                  this.currentStep++;
                  // Solo emite el evento 'step-changed' si no estamos en el último paso
                  if (this.currentStep < this.totalSteps) {
                      this.$emit('step-validate', this.categories);

                      this.$emit('step-changed', this.currentStep);

                  }
              } else if (direction === 'previous' && this.currentStep > 1) {
                  this.currentStep--;
                  this.$emit('step-changed', this.currentStep);
              }
          },*/
       /* navigateStepper(direction) {
            if (direction === 'next' && this.currentStep < this.totalSteps) {
                this.currentStep++;
                this.$emit('step-changed', this.currentStep); // Emitir un evento cuando se cambia de paso
            } else if (direction === 'previous' && this.currentStep > 1) {
                this.currentStep--;
                this.$emit('step-changed', this.currentStep); // Emitir un evento cuando se cambia de paso
            }
        },*/
        getFieldsForCurrentCategory() {
            return this.categories[this.currentStep - 1].items;
        },
        goBack() {
            this.$emit('go-back'); // Puedes manejar este evento en el componente padre si es necesario
            // O simplemente navega a donde necesites, por ejemplo, al último paso
            // this.currentStep = this.totalSteps;
        },
        submitPage() {
            this.$emit('submit-page');
        }
    }
}
</script>
