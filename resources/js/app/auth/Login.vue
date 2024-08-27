<template>
    <!--    <div class="form-content">

            <h1 class=""><img src="images/logo-pluss-header.png" width="320" alt=""></h1>
            <p class="text-center" style="font-size: 25px">Intranet</p>
            <div class="alert alert-warning">
                Ingresa con tu rut sin puntos y sin guión y la contraseña temporal: pluss2021
                (Deberas cambiar tu contraseña en tu primer ingreso)
            </div>

            <form class="text-left"  @submit.prevent="sendlogin()">

                <div class="form">

                    <div id="username-field" class="field-wrapper input">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <input id="rut" type="text" placeholder="RUT"  v-model="rut" class="form-control" name="rut" @blur="checkRut()" >
                    </div>

                    <div id="password-field" class="field-wrapper input mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        <input id="password" name="password" type="password" v-model="password" class="form-control" placeholder="Contraseña">

                    </div>
                    <div class="d-sm-flex justify-content-between">
                        <div class="field-wrapper toggle-pass">
                            <p class="d-inline-block">Mostrar Contraseña</p>
                            <label class="switch s-primary">
                                <input type="checkbox" id="toggle-password" class="d-none">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="field-wrapper">
                            <button type="submit" class="btn btn-primary" value="">Ingresar</button>
                        </div>

                    </div>


                    <div class="field-wrapper">
                        <a href="" class="forgot-pass-link">Recuperar Contraseña</a>
                    </div>

                </div>
            </form>
            <p class="terms-conditions">© 2022 Plusschile. Desarrolado por <a href="https://fizz.cl" target="_blank">Fizz</a></p>

        </div>-->
    <!--begin::Form-->
    <div class="d-flex flex-center flex-column flex-lg-row-fluid" data-kt-password-meter="true">
        <!--begin::Wrapper-->
        <div class="w-lg-500px p-10">
            <!--begin::Form-->
            <form class="form w-100" novalidate="novalidate" @submit.prevent="sendlogin()">
                <!--begin::Heading-->
                <div class="text-center mb-11">
                    <h1 class=""><img src="images/logo-pluss-header.png" width="320" alt=""></h1>
                    <p class="text-center" style="font-size: 25px">Intranet</p>
                    <div class="alert alert-warning">
                        Ingresa con tu rut sin puntos y sin guión y la contraseña temporal: pluss2021
                        (Deberas cambiar tu contraseña en tu primer ingreso)
                    </div>
                </div>
                <!--begin::Heading-->


                <!--begin::Input group=-->
                <div class="fv-row mb-8">
                    <!--begin::Email-->
                    <input type="text" placeholder="Ingrese rut"
                           v-model="rut"
                           @blur="checkRut()"
                           autocomplete="off"
                           class="form-control bg-transparent"/>
                    <!--end::Email-->
                </div>
                <!--end::Input group=-->
                <div class="fv-row mb-3">
                    <!--begin::Password-->
                    <!--                    <input type="password"
                                               placeholder="Ingrese password"
                                               v-model="password"
                                               autocomplete="off"
                                               class="form-control bg-transparent" />-->

                    <!--begin::Input wrapper-->
                    <div class="position-relative mb-3">
                        <input class="form-control bg-transparent"
                               placeholder="Ingrese password"
                               type="password"
                               v-model="password"
                               id="password"
                        />

                        <!--begin::Visibility toggle-->
                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                              @click="seePassword()">
                            <i class="bi bi-eye fs-2"  v-if="isPasswordVisible"></i>
                            <i class="bi bi-eye-slash fs-2" v-else></i>
                        </span>
                        <!--end::Visibility toggle-->
                    </div>

                    <!--end::Password-->
                </div>
                <!--end::Input group=-->
                <!--begin::Wrapper-->
                <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                    <div></div>
                    <!--begin::Link-->
                    <a href="" class="link-primary">¿Olvido contraseña?</a>
                    <!--end::Link-->
                </div>
                <!--end::Wrapper-->
                <!--begin::Submit button-->
                <div class="d-grid mb-10">
                    <button type="submit" class="btn btn-primary">
                        <!--begin::Indicator label-->
                        <span class="indicator-label">Ingresar</span>
                        <!--end::Indicator label-->
                        <!--begin::Indicator progress-->
                        <span class="indicator-progress">Por favor espere...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        <!--end::Indicator progress-->
                    </button>
                </div>
                <!--end::Submit button-->

            </form>
            <!--end::Form-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Form-->

</template>

<script>
import {
    validRutValue,
    validRutValues,
    getRutVerifier,
    validRutVerifier,
    normalizeRut,
    formatRut,
    validRut
} from "chilean-rutify";

export default {
    name: "Login",
    data() {
        return {
            rut: '',
            password: '',
            loading: false,
            isPasswordVisible: false,
        }
    },
    methods: {
        async sendlogin() {

            try {
                this.loading = true;

                if (this.rut == '' || this.password == '') {
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Debes ingresar tu rut y contraseña',
                    })
                    return;
                }

                const {status} = await axios.post('/login', {
                    rut: this.rut,
                    password: this.password
                });

                if (status === 200) {
                    this.loading = false;
                    this.$swal.fire({
                        title: 'Bienvenido',
                        text: 'Ingreso exitoso',
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '/home';
                        }
                    })


                }

            } catch (error) {
                this.loading = false;
                this.$swal.fire({
                    title: 'Error',
                    text: 'Rut o contraseña incorrectos',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                })
            }
        },
        checkRut() {
            if (validRut(this.rut)) {
                this.rut = formatRut(this.rut);
                this.rut = this.rut.replace('.', '');
                this.rut = this.rut.replace('.', '');
            } else {
                this.$swal.fire({
                    title: 'Error',
                    text: 'Rut incorrecto',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                })
            }
        },
        seePassword() {
            let password = document.getElementById('password');
            if (password.type === "password") {
                this.isPasswordVisible = true;
                password.type = "text";

            } else {
                password.type = "password";
                this.isPasswordVisible = false;
            }
        }
    }
}

</script>

<style scoped>

</style>
