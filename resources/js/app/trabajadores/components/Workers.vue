<template>
    <div class="row my-5 mx-5">
        <!-- Código Trabajador -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Código trabajador</label>
            <input class="form-control form-control-solid" type="text" v-model="form.codigo_trabajador" :disabled="isDisabled" />
        </div>

        <!-- Rut -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Rut</label>
            <input class="form-control form-control-solid" type="text" v-model="form.rut" :disabled="isDisabledInput" />
        </div>

        <!-- Primer Nombre -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Primer Nombre</label>
            <input class="form-control form-control-solid" type="text" v-model="form.primer_nombre" :disabled="isDisabledInput" />
        </div>

        <!-- Segundo Nombre -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Segundo Nombre</label>
            <input class="form-control form-control-solid" type="text" v-model="form.segundo_nombre" :disabled="isDisabledInput" />
        </div>

        <!-- Primer Apellido -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Primer Apellido</label>
            <input class="form-control form-control-solid" type="text" v-model="form.primer_apellido" :disabled="isDisabledInput" />
        </div>

        <!-- Segundo Apellido -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Segundo Apellido</label>
            <input class="form-control form-control-solid" type="text" v-model="form.segundo_apellido" :disabled="isDisabledInput" />
        </div>

        <!-- Fecha de Nacimiento -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Fecha de nacimiento</label>
            <input class="form-control form-control-solid" type="date" v-model="form.fecha_nac" :disabled="isDisabledInput" />
        </div>

        <!-- Estado Civil -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Estado Civil</label>
            <select v-model="form.estado_civil" class="form-select form-select-solid">
                <option disabled value="">Seleccione...</option>
                <option value="Soltero">Soltero</option>
                <option value="Casado">Casado</option>
                <option value="Viudo">Viudo</option>
                <option value="Divorciado">Divorciado</option>
                <option value="Unión Civil">Unión Civil</option>
            </select>
        </div>

        <!-- Sexo -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Sexo</label>
            <select v-model="form.sexo" class="form-select form-select-solid">
                <option disabled value="">---Seleccione---</option>
                <option value="masculino">Masculino</option>
                <option value="femenino">Femenino</option>
                <option value="Indeterminado">Indeterminado</option>
            </select>
        </div>

        <!-- Nivel de Estudio -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Nivel de estudio</label>
            <select v-model="form.grado_escolaridad" class="form-select form-select-solid">
                <option disabled value="">Seleccione...</option>
                <option value="SIN ESCOLARIDAD">SIN ESCOLARIDAD</option>
                <option value="BÁSICA">BÁSICA</option>
                <option value="MEDIA CIENTÍFICO HUMANISTA">MEDIA CIENTÍFICO HUMANISTA</option>
                <option value="MEDIA TÉCNICA PROFESIONAL">MEDIA TÉCNICA PROFESIONAL</option>
                <option value="TÉCNICO SUPERIOR INCOMPLETA">TÉCNICO SUPERIOR INCOMPLETA</option>
                <option value="TÉCNICO SUPERIOR COMPLETA">TÉCNICO SUPERIOR COMPLETA</option>
                <option value="PROFESIONAL INCOMPLETA">PROFESIONAL INCOMPLETA</option>
                <option value="PROFESIONAL COMPLETA">PROFESIONAL COMPLETA</option>
                <option value="MAGISTER">MAGISTER</option>
                <option value="DOCTORADO">DOCTORADO</option>
            </select>
        </div>

        <!-- Telefono Móvil -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Telefono Móvil</label>
            <input class="form-control form-control-solid" type="text" v-model="form.telefono_celular" :disabled="isDisabledInput" />
        </div>

        <!-- Telefono (Opcional) -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Telefono (Opcional)</label>
            <input class="form-control form-control-solid" type="text" v-model="form.telefono_fijo" :disabled="isDisabledInput" />
        </div>

        <!-- Correo -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Correo</label>
            <input class="form-control form-control-solid" type="email" v-model="form.correo" :disabled="isDisabledInput" />
        </div>

        <!-- Confirmar Correo -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Confirmar Correo</label>
            <input class="form-control form-control-solid" type="email" v-model="form.confirmar_correo" :disabled="isDisabledInput" />
        </div>

        <!-- Dirección -->
        <div class="col-md-12 mb-2">
            <label class="fs-6 fw-semibold mb-2">Dirección</label>
            <input class="form-control form-control-solid" type="text" v-model="form.direccion" :disabled="isDisabledInput" />
        </div>

        <!-- Región -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Región</label>
            <select v-model="form.region_id" class="form-select form-select-solid" @change="handleRegionChange">
                <option disabled value="">---Seleccione---</option>
                <!-- Opciones de regiones -->
                <option v-for="(region, index) in regiones" :key="index" :value="region.id">
                    {{ region.nombre_region }}
                </option>
            </select>
        </div>

        <!-- Comunas -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Comunas</label>
            <select v-model="form.comuna_id" class="form-select form-select-solid" :disabled="disabledComunas">
                <option disabled value="">---Seleccione---</option>
                <!-- Opciones de comunas -->
                <option v-for="(comuna, index) in comunas" :key="index" :value="comuna.id">
                    {{ comuna.nombre_comuna }}
                </option>
            </select>
        </div>

        <!-- Nacionalidad -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Nacionalidad</label>
            <select v-model="form.nacionalidad_id" class="form-select form-select-solid">
                <option disabled value="">---Seleccione---</option>
                <!-- Opciones de nacionalidades -->
                <option v-for="(nacionalidad, index) in nacionalidades" :key="index" :value="nacionalidad.id">
                    {{ nacionalidad.descripcion_nacionalidad }}
                </option>
            </select>
        </div>

        <!-- Carga Familiar, Pueblo Originario, y Discapacidad son switches similares al ejemplo anterior -->
        <!-- Example for switch - Carga Familiar -->
        <div class="col-md-8 mb-2">
            <label class="fs-6 fw-semibold mb-2">¿Posee Carga Familiar?</label>
            <label class="form-check form-switch form-check-custom form-check-solid">
                <input
                    class="form-check-input"
                    type="checkbox"
                    v-model="showCargaFamiliar"
                />
                <span class="form-check-label fw-semibold text-muted">Activar</span>
            </label>
        </div>

        <!-- Show or hide based on Vue's v-if directive -->
        <div v-if="showCargaFamiliar" class="col-md-4 mb-2">
            <button @click="toggleShowExtra"
                    type="button"
                    class="btn btn-success btn-sm">Agregar Carga</button>
        </div>

        <div class="col-md-8 mb-2">
            <label class="fs-6 fw-semibold mb-2">¿Pertenece a un Pueblo Originario?</label>
            <label class="form-check form-switch form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" v-model="pertenecePuebloOriginario"/>
                <span class="form-check-label fw-semibold text-muted">Activar</span>
            </label>
        </div>
        <div v-if="pertenecePuebloOriginario" class="col-md-4 mb-2">
            <!-- Aqui va un select de pueblos originarios -->
            <select class="form-select form-select-solid" v-model="puebloOriginarioSeleccionado">
                <option disabled value="">Seleccione un pueblo originario</option>
                <!-- Opciones de pueblos originarios -->
                <option v-for="(pueblo, index) in puebloOriginarios" :key="index" :value="pueblo.id">
                    {{ pueblo.pueblo_originario }}
                </option>
            </select>
        </div>

        <div class="col-md-8 mb-2">
            <label class="fs-6 fw-semibold mb-2">¿Posee alguna discapacidad o enfermedad?</label>
            <label class="form-check form-switch form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" v-model="poseeDiscapacidad"/>
                <span class="form-check-label fw-semibold text-muted">Activar</span>
            </label>
        </div>
        <div v-if="poseeDiscapacidad" class="col-md-4 mb-2">
            <button type="button" class="btn btn-success btn-sm">Agregar</button>
        </div>

        <CardRigth
            :isActive="showExtra"
            :title="'Carga Familiar'"
        >
            <template #renderClose>
                <button type="button"
                        @click="toggleShowExtra()"
                class="btn btn-sm btn-icon btn-active-color-primary h-40px w-40px me-n6"
                id="kt_engage_demos_close">

                <span class="svg-icon svg-icon-2">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
									<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                          transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
									<rect x="7.41422" y="6" width="16" height="2" rx="1"
                                          transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
								</svg>
							</span>

                </button>
            </template>
          <template #body>
              <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                  <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                      <span class="required">Rut</span>
                  </label>
                  <input
                      type="text"
                      class="form-control form-control-solid"
                      placeholder="Rut"
                      v-model="nuevoFamiliar.rut"
                  />
              </div>

              <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                  <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                      <span class="required">Nombre</span>
                  </label>
                  <input
                      type="text"
                      class="form-control form-control-solid"
                      placeholder="Nombre"
                      v-model="nuevoFamiliar.nombres"
                  />
              </div>

              <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                  <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                      <span class="required">Apellidos</span>
                  </label>
                  <input
                      type="text"
                      class="form-control form-control-solid"
                      placeholder="Apellidos"
                      v-model="nuevoFamiliar.apellidos"
                  />
              </div>

              <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                  <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                      <span class="required">Fecha Nacimiento</span>
                  </label>
                  <input
                      type="date"
                      class="form-control form-control-solid"
                      v-model="nuevoFamiliar.fecha_nacimiento"
                  />
              </div>
              <div class="col-md-8 mb-2">
                  <label class="fs-6 fw-semibold mb-2">¿Posee Fecha de Vencimiento?</label>
                  <label class="form-check form-switch form-check-custom form-check-solid">
                      <input class="form-check-input" type="checkbox" v-model="poseeFechaVencimiento"/>
                      <span class="form-check-label fw-semibold text-muted">Activar</span>
                  </label>
              </div>
              <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container" v-if="poseeFechaVencimiento">
                  <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                      <span class="required">Fecha Vencimiento</span>
                  </label>
                  <input
                      type="date"
                      class="form-control form-control-solid"
                      v-model="nuevoFamiliar.fecha_vencimiento"
                  />
              </div>
              <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                  <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">Parentesco</label>
                  <select v-model="nuevoFamiliar.parentesco_id" class="form-select form-select-solid">
                      <option disabled value="">---Seleccione---</option>
                      <!-- Opciones de nacionalidades -->
                      <option v-for="(parentesco, index) in parentesco" :key="index" :value="parentesco.id">
                          {{ parentesco.descripcion }}
                      </option>
                  </select>
              </div>
              <button type="button" @click="addFamiliar" class='btn btn-success btn-sm mt-5'>
                  Agregar
              </button>
              <!-- For handling familiares list -->
              <table class="table table-striped mt-10" v-if="familiar.length > 0">
                  <thead>
                  <tr>
                      <th>Rut</th>
                      <th>Nombres</th>
                      <th>Apellidos</th>
                      <th>Acciones</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr v-for="(item, index) in familiar" :key="index">
                      <td>{{ item.rut }}</td>
                      <td>{{ item.nombres }}</td>
                      <td>{{ item.apellidos }}</td>
                      <td>
                          <button class="btn btn-primary btn-sm">
                            <i class="fa fa-edit"></i>
                          </button>
                          <button class="btn btn-danger btn-sm" @click="removeFamiliar(index)">
                              <i class="fa fa-trash"></i>
                          </button>
                      </td>
                  </tr>
                  </tbody>
              </table>
              <!-- La parte de manejo de carga familiar se mantiene similar a la de React, ajustada a Vue -->

          </template>
        </CardRigth>


    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
import CardRigth from "@/components/CardRigth.vue";
export default {
    name: 'Workers',
    components: {
        CardRigth,
    },
    props: {
        form: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            // Inicialización de todas las propiedades usadas en el template
           /* form: {
                codigo_trabajador: '',
                rut: '',
                primer_nombre: '',
                segundo_nombre: '',
                primer_apellido: '',
                segundo_apellido: '',
                fecha_nac: '',
                estado_civil: '',
                sexo: '',
                grado_escolaridad: '',
                telefono_celular: '',
                telefono_fijo: '',
                correo: '',
                confirmar_correo: '',
                direccion: '',
                region_id: '',
                comuna_id: '',
                nacionalidad_id: '',
                pueblo_originario_id: '',
            },*/
            nuevoFamiliar: {
                rut: '',
                nombres: '',
                apellidos: '',
                fecha_nacimiento: '',
                fecha_vencimiento: '',
                parentesco_id: '',
                descripcion_parentesco: '',
            },
            showCargaFamiliar: false,
            showPuebloOriginario: false,
            showDiscapacidad: false,
            pertenecePuebloOriginario: false,
            poseeDiscapacidad: false,
            puebloOriginarioSeleccionado: '',
            isDisabled: true,
            showExtra: false,
            isDisabledInput: false,
            poseeFechaVencimiento: false,
            //disabledComunas: true,
            familiar: [],
            // Asumimos que las regiones, comunas y nacionalidades se cargan desde el estado global
        };
    },
    computed: {
        ...mapState({
            regiones: state => state.regiones.regiones,
            comunas: state => state.comunas.comunas,
            nacionalidades: state => state.nacionalidades.nacionalidades,
            puebloOriginarios: state => state.pueblosOrignarios.pueblosOriginarios,
            parentesco: state => state.parentesco.parentescos,
        }),
        disabledComunas() {
            return !this.form.region_id; // Deshabilita el selector de comunas si no se ha seleccionado una región
        },
    },
    watch: {
        'form.rut': function (newVal, oldVal) {
            if (newVal) {
                let value = newVal.replace(/\D/g, ''); // Remove non-numeric characters
                if (value.length > 1) {
                    value = value.slice(0, -1) + '-' + value.slice(-1); // Insert hyphen before last digit
                }
                this.form.rut = value; // Update the form.rut property
            }
        },
        'nuevoFamiliar.rut':function (newVal, oldVal) {
            if (newVal) {
                let value = newVal.replace(/\D/g, ''); // Remove non-numeric characters
                if (value.length > 1) {
                    value = value.slice(0, -1) + '-' + value.slice(-1); // Insert hyphen before last digit
                }
                this.nuevoFamiliar.rut = value; // Update the form.rut property
            }
        },

    },
    methods: {
        ...mapActions({
            loadRegiones: 'regiones/fetchRegiones', // Asegúrate de usar los nombres correctos definidos en tu store
            loadComunas: 'comunas/fetchComunas',
            loadComunasId: 'comunas/fetchComunasById', // Esta acción puede necesitar un parámetro adicional para la ID de la región
            loadNacionalidades: 'nacionalidades/fetchNacionalidades',
            loadPueblosOriginarios: 'pueblosOrignarios/fetchPueblosOriginarios',
            loadParentescos: 'parentesco/fetchParentescos',
        }),
        handleRegionChange() {
            this.loadComunasId(this.form.region_id);

        },
        toggleShowExtra() {
            this.showExtra = !this.showExtra;
        },
        addFamiliar() {

            if (!this.poseeFechaVencimiento) {
                this.nuevoFamiliar.fecha_vencimiento = '2099-12-31';
            }

            this.familiar.push({...this.nuevoFamiliar});
            this.resetNuevoFamiliar();
        },
        resetNuevoFamiliar() {
            this.nuevoFamiliar = {
                rut: '',
                nombres: '',
                apellidos: '',
                fecha_nacimiento: '',
                fecha_vencimiento: '',
                parentesco_id: '',
                descripcion_parentesco: '',
            };
        },
        removeFamiliar(index) {
            this.familiar.splice(index, 1);
        },
    },
    mounted() {
        // Cargar datos iniciales como regiones, comunas y nacionalidades
        this.loadRegiones();
        this.loadComunas()
        this.loadNacionalidades();
        this.loadPueblosOriginarios();
        this.loadParentescos();
    },
};
</script>

<style scoped>
/* Tus estilos CSS */
</style>


