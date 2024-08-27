<template>
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                <!--begin: Pic-->
                <div class="me-7 mb-4">
                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                        <img :src="base_url+'/assets/media/avatars/300-1.jpg'" alt="image"/>
                        <div
                            class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                    </div>
                </div>
                <!--end::Pic-->
                <!--begin::Info-->
                <div class="flex-grow-1">
                    <!--begin::Title-->
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <!--begin::User-->
                        <div class="d-flex flex-column">
                            <!--begin::Name-->
                            <div class="d-flex align-items-center mb-2">
                                <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">
                                    {{ data.primer_nombre }} {{ data.segundo_nombre }} {{ data.primer_apellido }}
                                    {{ data.segundo_apellido }}
                                </a>
                            </div>
                            <!--end::Name-->
                            <!--begin::Info-->
                            <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                <a href="#"
                                   class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                    <span class="svg-icon svg-icon-4 me-1">
																	<svg width="18" height="18" viewBox="0 0 18 18"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path opacity="0.3"
                                                                              d="M16.5 9C16.5 13.125 13.125 16.5 9 16.5C4.875 16.5 1.5 13.125 1.5 9C1.5 4.875 4.875 1.5 9 1.5C13.125 1.5 16.5 4.875 16.5 9Z"
                                                                              fill="currentColor"/>
																		<path
                                                                            d="M9 16.5C10.95 16.5 12.75 15.75 14.025 14.55C13.425 12.675 11.4 11.25 9 11.25C6.6 11.25 4.57499 12.675 3.97499 14.55C5.24999 15.75 7.05 16.5 9 16.5Z"
                                                                            fill="currentColor"/>
																		<rect x="7" y="6" width="4" height="4" rx="2"
                                                                              fill="currentColor"/>
																	</svg>
																</span>
                                    <!--end::Svg Icon-->{{ cargo }}</a>
                                <a href="#"
                                   class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen018.svg-->
                                    <span class="svg-icon svg-icon-4 me-1">
																	<svg width="24" height="24" viewBox="0 0 24 24"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path opacity="0.3"
                                                                              d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z"
                                                                              fill="currentColor"/>
																		<path
                                                                            d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z"
                                                                            fill="currentColor"/>
																	</svg>
																</span>
                                    <!--end::Svg Icon-->{{ data.contrato.ubicacion.nombre_ubicacion }}</a>
                                <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                    <!--begin::Svg Icon | path: icons/duotune/communication/com011.svg-->
                                    <span class="svg-icon svg-icon-4 me-1">
																	<svg width="24" height="24" viewBox="0 0 24 24"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path opacity="0.3"
                                                                              d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z"
                                                                              fill="currentColor"/>
																		<path
                                                                            d="M21 5H2.99999C2.69999 5 2.49999 5.10005 2.29999 5.30005L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30005C21.5 5.10005 21.3 5 21 5Z"
                                                                            fill="currentColor"/>
																	</svg>
																</span>
                                    <!--end::Svg Icon-->{{ data.correo }}</a>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->


                        <!--end::Actions-->
                    </div>
                    <!--end::Title-->
                    <!--begin::Stats-->
                    <div class="d-flex flex-wrap flex-stack">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-column flex-grow-1 pe-8">
                            <!--begin::Stats-->
                            <div class="d-flex flex-wrap">
                                <!--begin::Stat-->
                                <div
                                    class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                        <span class="svg-icon svg-icon-3 svg-icon-success me-2">
																			<svg width="24" height="24"
                                                                                 viewBox="0 0 24 24" fill="none"
                                                                                 xmlns="http://www.w3.org/2000/svg">
																				<rect opacity="0.5" x="13" y="6"
                                                                                      width="13" height="2" rx="1"
                                                                                      transform="rotate(90 13 6)"
                                                                                      fill="currentColor"/>
																				<path
                                                                                    d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                                                                                    fill="currentColor"/>
																			</svg>
																		</span>
                                        <!--end::Svg Icon-->
                                        <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="4500"
                                             data-kt-countup-prefix="$">0
                                        </div>
                                    </div>
                                    <!--end::Number-->
                                    <!--begin::Label-->
                                    <div class="fw-semibold fs-6 text-gray-400">Earnings</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Stat-->

                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Progress-->
                        <div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
                            <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                <span class="fw-semibold fs-6 text-gray-400">Perfil Completado</span>
                                <span class="fw-bold fs-6">50%</span>
                            </div>
                            <div class="h-5px mx-3 w-100 bg-light mb-3">
                                <div class="bg-success rounded h-5px" role="progressbar" :style="{width: profileCompletion + '%'}"
                                     :aria-valuenow="profileCompletion" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <!--end::Progress-->
                    </div>
                    <!--end::Stats-->
                </div>
                <!--end::Info-->
            </div>
            <!--end::Details-->
            <!--begin::Navs-->
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" href="#">Configuracion</a>
                </li>

            </ul>
            <!--begin::Navs-->
        </div>
    </div>
    <!--end::Navbar-->
</template>
<script>
export default {
    name: "PersonalInformation",
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
            base_url: window.location.origin,
            cargo: '',
            profileCompletion: 0,
        }
    },
    methods: {
        loadData() {
            if (this.data.hasOwnProperty('contrato') && this.data.contrato.hasOwnProperty('cargo')) {
                this.cargo = this.data.contrato.cargo.nombre_cargo || '';
            } else {
                this.cargo = 'Valor predeterminado';
            }
            this.calculateProfileCompletion();
        },
        calculateProfileCompletion() {
            let fields = ['rut', 'primer_nombre', 'segundo_nombre', 'primer_apellido', 'segundo_apellido', 'fecha_nac', 'telefono_movil', 'telefono_fijo', 'correo', 'direccion', 'region_id', 'comuna_id'];
            let filledFields = 0;

            fields.forEach(field => {
                if (this[field] && this[field] !== 'Valor predeterminado') {
                    filledFields++;
                }
            });

            this.profileCompletion = (filledFields / fields.length) * 100;
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

}
</script>
<style scoped>

</style>
