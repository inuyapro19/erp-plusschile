<template>
    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
             data-bs-target="#kt_account_profile_details" aria-expanded="true"
             aria-controls="kt_account_profile_details">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Informacion Personal</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="kt_account_settings_profile_details" class="collapse show">
            <!--begin::Form-->
            <form id="kt_account_profile_details_form" class="form">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">RUT</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="rut" v-model="rut"
                                   class="form-control form-control-lg form-control-solid"
                                   placeholder="RUT" :disabled="disabled" value=""/>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Primer Nombre</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="primer_nombre"
                                   v-model="primer_nombre"
                                   :disabled="disabled"
                                   class="form-control form-control-lg form-control-solid" placeholder="Primer Nombre"
                                   value=""/>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Segundo Nombre</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="segundo_nombre"
                                   v-model="segundo_nombre"
                                   :disabled="disabled"
                                   class="form-control form-control-lg form-control-solid" placeholder="Segundo Nombre"
                                   value=""/>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Primer Apellido</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="primer_apellido"
                                   v-model="primer_apellido"
                                   :disabled="disabled"
                                   class="form-control form-control-lg form-control-solid" placeholder="Primer Apellido"
                                   value=""/>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Segundo Apellido</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="segundo_apellido"
                                   v-model="segundo_apellido"
                                   :disabled="disabled"
                                   class="form-control form-control-lg form-control-solid"
                                   placeholder="Segundo Apellido" value=""/>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Fecha de Nacimiento</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="date" name="fecha_nac"
                                   v-model="fecha_nac"
                                   :disabled="disabled"
                                   class="form-control form-control-lg form-control-solid"
                                   placeholder="Fecha de Nacimiento" value=""/>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Teléfono Móvil</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="tel" name="telefono_movil"
                                   v-model="telefono_movil"

                                   class="form-control form-control-lg form-control-solid" placeholder="Teléfono Móvil"
                                   value=""/>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Teléfono Fijo</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="tel" name="telefono_fijo"
                                   v-model="telefono_fijo"

                                   class="form-control form-control-lg form-control-solid" placeholder="Teléfono Fijo"
                                   value=""/>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Correo</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="email" name="correo"
                                   v-model="correo"
                                   :disabled="disabled"
                                   class="form-control form-control-lg form-control-solid"
                                   placeholder="Correo" value=""/>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Dirección</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="direccion"
                                   v-model="direccion"
                                   :disabled="disabled"
                                   class="form-control form-control-lg form-control-solid"
                                   placeholder="Dirección" value=""/>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Región</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <select v-model="region_id" :disabled="disabled" @change="updateComunas"
                                    class="form-select form-select-lg form-select-solid">
                                <option v-for="region in regiones" :value="region.id">{{
                                        region.nombre_region
                                    }}
                                </option>
                            </select>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Comuna</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <select v-model="comuna_id" :disabled="disabled"
                                    class="form-select form-select-lg form-select-solid">
                                <option v-for="comuna in comunas" :value="comuna.id">{{ comuna.nombre_comuna }}</option>
                            </select>
                        </div>
                        <!--end::Col-->
                    </div>
                </div>
                <!--end::Card body-->
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="reset" class="btn btn-light btn-active-light-primary me-2">Descartar</button>
                    <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Guardar
                    </button>
                </div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Basic info-->
</template>

<script>
export default {
    name: "ProfileDetails",
    props: {
        data: {
            type: [Object, Array],
            default: () => {
                return {}
            }
        }
    },
    data() {
        return {
            disabled: true,
            regiones: [],
            comunas: [],
            comuna_id: 0,
            region_id: 0,
            rut: "",
            primer_nombre: "",
            segundo_nombre: "",
            primer_apellido: "",
            segundo_apellido: "",
            fecha_nac: "",
            telefono_movil: "",
            telefono_fijo: "",
            correo: "",
            direccion: "",
            region: "",
            comuna: "",
        };
    },
    methods: {
        loadData() {
            this.rut = this.data.hasOwnProperty('rut') ? this.data.rut : 'Valor predeterminado';
            this.primer_nombre = this.data.hasOwnProperty('primer_nombre') ? this.data.primer_nombre : 'Valor predeterminado';
            this.segundo_nombre = this.data.hasOwnProperty('segundo_nombre') ? this.data.segundo_nombre : 'Valor predeterminado';
            this.primer_apellido = this.data.hasOwnProperty('primer_apellido') ? this.data.primer_apellido : 'Valor predeterminado';
            this.segundo_apellido = this.data.hasOwnProperty('segundo_apellido') ? this.data.segundo_apellido : 'Valor predeterminado';
            this.fecha_nac = this.data.hasOwnProperty('fecha_nac') ? this.data.fecha_nac : 'Valor predeterminado';
            this.telefono_movil = this.data.hasOwnProperty('telefono_celular') ? this.data.telefono_celular : 'Valor predeterminado';
            this.telefono_fijo = this.data.hasOwnProperty('telefono_local') ? this.data.telefono_local : 'Valor predeterminado';
            this.correo = this.data.hasOwnProperty('correo') ? this.data.correo : 'Valor predeterminado';
            this.direccion = this.data.hasOwnProperty('direccion') ? this.data.direccion : 'Valor predeterminado';
            this.region_id = this.data.hasOwnProperty('region_id') ? this.data.region_id : 'Valor predeterminado';
            this.comuna_id = this.data.hasOwnProperty('comuna_id') ? this.data.comuna_id : 'Valor predeterminado';
        },
        async getRegiones() {
            await axios.get("/regiones").then((response) => {
                this.regiones = response.data;
            });
        },
        async updateComunas() {

            await axios.get("/comunas").then((response) => {
                this.comunas = response.data;
            });

        },
        async saveProfile() {
            this.disabled = true;
            axios.post("profile/saveProfile", this.data);
        },
    },
    watch: {
        // Observar cambios en la prop 'data'
        data: {
            immediate: true, // Ejecutar el watcher inmediatamente después de la creación del componente
            handler(newValue) {
                if (newValue) {
                    this.loadData();
                }
            }
        }
    },
    mounted() {

        this.getRegiones();
        this.updateComunas();
    },
};
</script>
<style scoped>

</style>
