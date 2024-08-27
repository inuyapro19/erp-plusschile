<template>
    <div class="col-lg-11 mx-auto">

        <div class="row">
            <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-5">
                <div class="form mt-7">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Código Trabajador</label>
                                <input type="text" v-model="formulario.codigo_trabajador" :class="inputClass" disabled>

                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">RUT</label>
                                <!--Debes mejorar esta opcion con el nuevo validador de rut-->
                                <input type="text" v-model="formulario.rut" @blur="comprobar_rut"
                                       :class="errors.rut !== undefined ? errorsClass : inputClass"
                                       :disabled="editarTrabajador">
                                <div v-if="errors.rut">
                                    <div class="invalid-feedback" style="display: block"
                                         v-for="(mensaje_rut , index) in errors.rut">{{ mensaje_rut }}
                                    </div>
                                </div>

                                <div v-show="rut_errorneo" class="invalid-feedback" style="display: block">
                                    El RUT Ingresado no es valido
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Primer Nombre</label>
                                <input type="text" v-model="formulario.primer_nombre"
                                       :class="errors.primer_nombre !== undefined ? errorsClass : inputClass"
                                       :disabled="editarTrabajador">
                                <div v-if="errors.primer_nombre">
                                    <div class="invalid-feedback" style="display: block"
                                         v-for="(mensaje_primer_nombre , index) in errors.primer_nombre">
                                        {{ mensaje_primer_nombre }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Segundo Nombre(Opcional)</label>
                                <input type="text" v-model="formulario.segundo_nombre"
                                       :class="errors.segundo_nombre !== undefined ? errorsClass : inputClass"
                                       :disabled="editarTrabajador">
                                <div v-if="errors.segundo_nombre">
                                    <div class="invalid-feedback" style="display: block"
                                         v-for="(mensaje_segundo_nombre , index) in errors.segundo_nombre">
                                        {{ mensaje_segundo_nombre }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Primer Apellido</label>
                                <input type="text" v-model="formulario.primer_apellido"
                                       :class="errors.primer_apellido !== undefined ? errorsClass : inputClass"
                                       :disabled="editarTrabajador">
                                <div v-if="errors.primer_apellido">
                                    <div class="invalid-feedback" style="display: block"
                                         v-for="(mensaje_primer_apellido , index) in errors.primer_apellido">
                                        {{ mensaje_primer_apellido }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Segundo Apellido(Opcional)</label>
                                <input type="text" v-model="formulario.segundo_apellido"
                                       :class="errors.segundo_apellido !== undefined ? errorsClass : inputClass"
                                       :disabled="editarTrabajador">
                                <div v-if="errors.segundo_apellido">
                                    <div class="invalid-feedback" style="display: block"
                                         v-for="(mensaje_segundo_apellido , index) in errors.segundo_apellido">
                                        {{ mensaje_segundo_apellido }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">

                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Fecha nacimiento</label>
                                <!--                            <input type="date" v-model="formulario.fecha_nac" :class="errors.fecha_nac !== undefined ? errorsClass : inputClass" :disabled="editarTrabajador">-->
                                <date-picker
                                    v-model="formulario.fecha_nac"
                                    :disabled="editarTrabajador"
                                    valueType="format"/>
                                <!--                                <div class="position-relative d-flex align-items-center">
                                                                    &lt;!&ndash;begin::Svg Icon | path: icons/duotune/general/gen014.svg&ndash;&gt;
                                                                    <span class="svg-icon position-absolute ms-4 mb-1 svg-icon-2">
                                                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                                    <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor" />
                                                                                                    <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor" />
                                                                                                    <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor" />
                                                                                                </svg>
                                                                                            </span>
                                                                    &lt;!&ndash;end::Svg Icon&ndash;&gt;
                                                                    <input
                                                                        class="form-control form-control-solid ps-12"
                                                                        v-model="formulario.fecha_nac"
                                                                        name="date"
                                                                        placeholder="Seleccione una fecha"
                                                                        id="kt_datepicker_1" />
                                                                </div>-->
                            </div>

                            <div v-if="errors.fecha_nac">
                                <div class="invalid-feedback" style="display: block"
                                     v-for="(mensaje_fecha_nac , index) in errors.fecha_nac">{{ mensaje_fecha_nac }}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Nivel de estudio</label>
                                <select name="grado_escolaridad" v-model="formulario.grado_escolaridad"
                                        :class="errors.grado_escolaridad !== undefined ? errorsClass : selectClass"
                                        id="grado_escolaridad" :disabled="editarTrabajador">
                                    <option value="0">-----</option>
                                    <option v-for="(escolaridad, index) in grados_escolaridad" :value="escolaridad">
                                        {{ escolaridad }}
                                    </option>
                                </select>
                                <div v-if="errors.grado_escolaridad">
                                    <div class="invalid-feedback" style="display: block"
                                         v-for="(mensaje_grado , index) in errors.grado_escolaridad">{{ mensaje_grado }}
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Estado civil</label>
                                <select name="estado_civil"
                                        v-model="formulario.estado_civil"
                                        :class="errors.estado_civil !== undefined ? errorsClass : selectClass"
                                        id="estado_civil" :disabled="editarTrabajador">
                                    <option value="0">-----</option>
                                    <option v-for="status in maritalStatuses" :value="status">{{ status }}</option>
                                </select>
                                <div v-if="errors.estado_civil">
                                    <div class="invalid-feedback" style="display: block"
                                         v-for="(mensaje_estado_civil , index) in errors.estado_civil">
                                        {{ mensaje_estado_civil }}
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Sexo</label>
                                <select name="sexo" v-model="formulario.sexo"
                                        :class="errors.sexo !== undefined ? errorsClass : selectClass" id="sexo"
                                        :disabled="editarTrabajador">
                                    <option value="0">-----</option>
                                    <option value="masculino">Masculino</option>
                                    <option value="femenino">Femenino</option>
                                    <option value="Indeterminado ">Indeterminado</option>
                                </select>
                                <div v-if="errors.sexo">
                                    <div class="invalid-feedback" style="display: block"
                                         v-for="(mensaje_sexo , index) in errors.sexo">{{ mensaje_sexo }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Télefono Móvil</label>
                                <input type="text" v-model="formulario.telefono_obligatorio"
                                       :class="errors.telefono_celular !== undefined ? errorsClass : inputClass"
                                       :disabled="editarTrabajador">
                                <div v-if="errors.telefono_celular">
                                    <div class="invalid-feedback" style="display: block"
                                         v-for="(mensaje_telefono_celular , index) in errors.telefono_celular">
                                        {{ mensaje_telefono_celular }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="fv-row mb-7">
                                <label class=" s-6 fw-semibold mb-2">Télefono (Opcional)</label>
                                <input type="text" v-model="formulario.telefono_opcional"
                                       class="form-control form-control-solid" :disabled="editarTrabajador">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Correo</label>
                                <input type="email" v-model="formulario.correo"
                                       :class="errors.correo !== undefined ? errorsClass : inputClass"
                                       :disabled="editarTrabajador">
                                <div v-if="errors.correo">
                                    <div class="invalid-feedback" style="display: block"
                                         v-for="(mensaje_correo , index) in errors.correo">{{ mensaje_correo }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Confirmar Correo</label>
                                <input type="email" v-model="formulario.confirmar_correo"
                                       :class="errors.confirmar_correo !== undefined ? errorsClass : inputClass"
                                       :disabled="editarTrabajador">
                                <div v-if="errors.confirmar_correo">
                                    <div class="invalid-feedback" style="display: block"
                                         v-for="(mensaje_confirmar_correo , index) in errors.confirmar_correo">
                                        {{ mensaje_confirmar_correo }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Dirección</label>
                                <input type="text" v-model="formulario.direccion"
                                       :class="errors.direccion !== undefined ? errorsClass : inputClass"
                                       :disabled="editarTrabajador">
                                <div v-if="errors.direccion">
                                    <div class="invalid-feedback" style="display: block"
                                         v-for="(mensaje_direccion , index) in errors.direccion">{{ mensaje_direccion }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Región</label>
                                <select v-model="formulario.region_id"
                                        :class="errors.region_id !== undefined ? errorsClass : selectClass"
                                        @change="cargarCities()" :disabled="editarTrabajador">
                                    <option value="0">Selecciones Región</option>
                                    <option v-for="(region , index) in regiones" :value="region.id">
                                        {{ region.nombre_region }}
                                    </option>
                                </select>
                                <div v-if="errors.region_id">
                                    <div class="invalid-feedback" style="display: block"
                                         v-for="(mensaje_region , index) in errors.region_id">{{ mensaje_region }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Comuna</label>
                                <select v-model="formulario.comuna_id"
                                        :class="errors.comuna_id !== undefined ? errorsClass : selectClass"
                                        :disabled="editarTrabajador">
                                    <option value="0">Selecciones Comuna</option>
                                    <option v-for="(comuna , index) in comunas" :value="comuna.id">
                                        {{ comuna.nombre_comuna }}
                                    </option>
                                </select>
                                <div v-if="errors.comuna_id">
                                    <div class="invalid-feedback" style="display: block"
                                         v-for="(mensaje_comuna , index) in errors.comuna_id">{{ mensaje_comuna }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2" for="">Nacionalidad</label>
                                <select name="nacionalidad"
                                        :class="errors.nacionalidad_id !== undefined ? errorsClass : selectClass"
                                        v-model="formulario.nacionalidad" id="" :disabled="editarTrabajador">
                                    <option value="">-------------</option>
                                    <option v-for="(nacionalidades, index) in nacionalidad" :value="nacionalidades.id">
                                        {{ nacionalidades.descripcion_nacionalidad }}
                                    </option>

                                </select>
                                <div v-if="errors.nacionalidad_id">
                                    <div class="invalid-feedback" style="display: block"
                                         v-for="(mensaje_nacionalidad , index) in errors.nacionalidad_id">
                                        {{ mensaje_nacionalidad }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5 mb-5">
                        <div class="col-md-5">
                            <label class="fs-6 fw-semibold mb-2" for="tiene_familia">Carga Familiar</label>
                        </div>
                        <div class="col-md-3">

                            <!--                            <label class="switch s-icons s-outline s-outline-success mr-2">
                                                            <input type="checkbox" id="tiene_familia" v-model="formulario.tiene_familia" checked :disabled="editarTrabajador">
                                                            <span class="slider"></span>
                                                        </label>-->
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="tiene_familia"
                                       v-model="formulario.tiene_familia"
                                       checked
                                       :disabled="editarTrabajador"/>
                                <label class="form-check-label fw-semibold text-gray-400 ms-3" for="status"></label>
                            </div>
                        </div>
                        <div class="col-md-4" v-show="formulario.tiene_familia">
                            <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                                    data-target="#carga_familiar"><i class="fa fa-plus"></i> Agregar carga
                            </button>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <label for="perteneces_pueblo_originario" class="fs-6 fw-semibold mb-2">Pertenece a un
                                pueblo orignario</label>
                        </div>
                        <div class="col-md-3">

                            <!--                            <label class="switch s-icons s-outline s-outline-success  mr-2">
                                                            <input type="checkbox" id="perteneces_pueblo_originario" v-model="formulario.perteneces_pueblo_originario" :disabled="editarTrabajador" checked>
                                                            <span class="slider"></span>
                                                        </label>-->

                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="perteneces_pueblo_originario"
                                       v-model="formulario.perteneces_pueblo_originario"
                                       :disabled="editarTrabajador"
                                       checked
                                />
                                <label class="form-check-label fw-semibold text-gray-400 ms-3" for="status"></label>
                            </div>

                        </div>
                        <div class="col-md-4" v-show="formulario.perteneces_pueblo_originario">

                            <select name="pueblo_originario_id" v-model="formulario.pueblo_originario_id"
                                    class="form-control form-control-sm" :disabled="editarTrabajador">
                                <option value="" selected>Seleccione</option>
                                <option v-for="(pueblo, index) in pueblo_originario" :value="pueblo.id">
                                    {{ pueblo.pueblo_originario }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3 mb-3">
                        <div class="col-md-5">
                            <label for="tiene_discapacidad" class="fs-6 fw-semibold mb-2">Salud</label>
                        </div>
                        <div class="col-md-3">

                            <!--                            <label class="switch s-icons s-outline s-outline-success  mr-2">
                                                            <input type="checkbox" id="tiene_discapacidad" v-model="formulario.tiene_discapacidad" :disabled="editarTrabajador" checked>
                                                            <span class="slider"></span>
                                                        </label>-->

                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="tiene_discapacidad"
                                       v-model="formulario.tiene_discapacidad"
                                       :disabled="editarTrabajador"
                                       checked
                                />
                                <label class="form-check-label fw-semibold text-gray-400 ms-3" for="status"></label>
                            </div>


                        </div>
                        <div class="col-md-4" v-show="formulario.tiene_discapacidad">
                            <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal"
                                    data-target="#enfermedad"><i class="fa fa-plus"></i> Agregar
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Submit Field -->

        </div>


        <Familiar :parentesco="parentesco" :editarTrabajador="editarTrabajador"></Familiar>
        <Enfermedad></Enfermedad>
    </div>

</template>

<script>
import Familiar from "./Familiar";
import Enfermedad from "./Enfermedad";
import {mapState} from "vuex";
//const validate_rut = require('rut-regex');
import {validate, clean, format, getCheckDigit} from 'rut.js'
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/es';

export default {
    components: {
        Familiar,
        Enfermedad
    },
    props: {
        errors: {
            type: Array,
            required: true
        },
        inputClass: {
            type: String,
            default: ''
        },
        errorsClass: {
            type: String,
            default: ''
        },
        regiones: {
            type: Array,
            default: () => []
        },
        comunas: {
            type: Array,
            default: () => []
        },
        cargaFamiliar: {
            type: Array,
            default: () => []
        },
        editarTrabajador: {
            type: Boolean,
            default: false
        },
        selectClass: {
            type: String,
            default: ''
        }
    },
    computed: {
        ...mapState('trabajador', ['formulario']),
        rutValido: () => this.rut_valido
    },
    watch: {
        'formulario.rut': function (val) {
            this.formulario.rut = format(val)
        },
        'formulario.fecha_nac': function (val) {
            this.formulario.fecha_nac = val
        },
        'formulario.tiene_familia': function (val) {
            this.formulario.tiene_familia = val
        },
        'formulario.perteneces_pueblo_originario': function (val) {
            this.formulario.perteneces_pueblo_originario = val
        },
        'formulario.tiene_discapacidad': function (val) {
            this.formulario.tiene_discapacidad = val
        },
        regiones: function (val) {
            this.regiones = val
        },
    },
    data() {
        return {
            parentesco: {
                rut: '',
                nombres: '',
                apellidos: '',
                fecha_nacimiento: '',
                fecha_termino_carga: '',
                parentesco_id: 0,
                parentenco: ''
            },
            nacionalidad: [],
            pueblo_originario: [],
            grados_escolaridad: [
                'SIN ESCOLARIDAD', 'BÁSICA', 'MEDIA CIENTÍFICO HUMANISTA', 'MEDIA TÉCNICA PROFESIONAL', 'TÉCNICO SUPERIOR INCOMPLETA', 'TÉCNICO SUPERIOR COMPLETA',
                'PROFESIONAL INCOMPLETA', 'PROFESIONAL COMPLETA', 'MAGISTER', 'DOCTORADO'
            ],
            rut_valido: false,
            rut_errorneo: false,
            maritalStatuses: ['Soltero', 'Casado', 'Viudo', 'Divorciado', 'Unión Civil']

        }
    },
    mounted() {
        this.cargarNacionalidad()
        this.cargarPueblos()
        this.cargarCities()
    },
    methods: {
        async cargarCities() {
            try {
                let id = this.formulario.region_id
                const {data, status} = await axios.get('/comunas/' + id)
                if (status === 200) {
                    //this.formulario.comuda_id = '0'
                    this.comunas = data
                }
            } catch (e) {
                console.log(e)
            }

        },
        async cargarNacionalidad() {
            await axios.get('/nacionalidades').then(res => {
                this.nacionalidad = res.data
            })
        },
        async cargarPueblos() {
            await axios.get('/pueblos_originarios').then(res => {
                this.pueblo_originario = res.data
            })
        },
        comprobar_rut() {
            /* console.log(this.formulario.rut)
            this.rut_valido = validate_rut({exact: true, dot: true, hyphen: true}).test(this.formulario.rut)
             console.log(this.rut_valido)*/

            this.rut_valido = validate(this.formulario.rut)
            this.formulario.rut = format_sin_puntos(this.formulario.rut)
            if (this.rut_valido) {
                this.rut_errorneo = false
            } else {
                this.rut_errorneo = true
            }
        }
    }

}

function format_sin_puntos(rut) {
    rut = clean(rut)

    let result = rut.slice(-4, -1) + '-' + rut.substr(rut.length - 1)
    for (let i = 4; i < rut.length; i += 3) {
        result = rut.slice(-3 - i, -i) + result
    }

    return result
}
</script>
<style scoped>
.mx-datepicker {
    width: 100%;
}
</style>

