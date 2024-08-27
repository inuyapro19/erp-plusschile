<template>
    <!--begin::Sign-in Method-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
             data-bs-target="#kt_account_signin_method">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Cambio de Contraseña</h3>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Content-->
        <div id="kt_account_settings_signin_method" class="collapse show">
            <!--begin::Card body-->
            <div class="card-body border-top p-9">

                <!--begin::Password-->
                <div class="d-flex flex-wrap align-items-center mb-10">
                    <!--begin::Label-->
                    <div id="kt_signin_password" v-show="!showForm">
                        <div class="fs-6 fw-bold mb-1">Contraseña</div>
                        <div class="fw-semibold text-gray-600">************</div>
                    </div>
                    <!--end::Label-->
                    <!--begin::Edit-->
                    <div id="kt_signin_password_edit" class="flex-row-fluid" v-show="showForm">
                        <!--begin::Form-->
                        <form id="kt_signin_change_password" class="form" novalidate="novalidate">
                            <div class="row mb-1">

                                <div class="col-lg-4">
                                    <div class="fv-row mb-0">
                                        <label for="newpassword" class="form-label fs-6 fw-bold mb-3">Nueva Contraseña</label>
                                        <input type="password"
                                               class="form-control form-control-lg form-control-solid"
                                               v-model="password"
                                               name="newpassword" id="newpassword"/>
                                        <div v-if="errors.password" class="text-danger">{{ errors.password }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="fv-row mb-0">
                                        <label for="confirmpassword" class="form-label fs-6 fw-bold mb-3">Repetir Contraseña</label>
                                        <input type="password"
                                               v-model="password_confirmation"
                                               class="form-control form-control-lg form-control-solid"
                                               name="confirmpassword" id="confirmpassword"/>
                                        <div v-if="errors.password_confirmation" class="text-danger">{{ errors.password_confirmation }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex">
                                <button id="kt_password_submit"
                                        type="button"
                                        class="btn btn-primary me-2 px-6"
                                        @click="updatePassword"
                                >
                                    Guardar
                                </button>
                                <button id="kt_password_cancel" type="button"
                                        @click="showForm = !showForm"
                                        class="btn btn-color-gray-400 btn-active-light-primary px-6">
                                    Cancelar
                                </button>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Edit-->
                    <!--begin::Action-->
                    <div id="kt_signin_password_button" class="ms-auto">
                        <button class="btn btn-light btn-active-light-primary" @click="showForm = !showForm">Cambiar
                            Password
                        </button>
                    </div>
                    <!--end::Action-->
                </div>
                <!--end::Password-->

            </div>
            <!--end::Card body-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Sign-in Method-->
</template>

<script>
export default {
    data() {
        return {
            current_password: '',
            password: '',
            password_confirmation: '',
            showForm: false,
            errors: {
                password: '',
                password_confirmation: ''
            },
            rules: {
                password: value => {
                    if (!value) {
                        return 'La contraseña es obligatoria';
                    } else if (value.length < 8) {
                        return 'La contraseña debe tener al menos 8 caracteres';
                    } else {
                        return true;
                    }
                },
                password_confirmation: value => {
                    if (!value) {
                        return 'La confirmación de la contraseña es obligatoria';
                    } else if (value !== this.password) {
                        return 'Las contraseñas no coinciden';
                    } else {
                        return true;
                    }
                }
            }
        }
    },
    watch: {
        password(value) {
            this.errors.password = this.rules.password(value) === true ? '' : this.rules.password(value);
        },
        password_confirmation(value) {
            this.errors.password_confirmation = this.rules.password_confirmation(value) === true ? '' : this.rules.password_confirmation(value);
        }
    },
    methods: {

        updatePassword() {
            if (this.password !== this.password_confirmation) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Las contraseñas no coinciden',
                });
                return;
            }

            // Proceed with the password update
            axios.post('/profile/changepassword', {
                password: this.password,
                password_confirmation: this.password_confirmation,
            }).then(response => {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Contraseña actualizada correctamente',
                });

                this.showForm = false;
                this.password = '';
                this.password_confirmation = '';

            }).catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un error al actualizar la contraseña',
                });
            });

        },
    },
}
</script>

<style scoped>

</style>
