<template>

    <div class="container mt-5">
        <CardComponent :title="title">
            <template #header>
                <div class="row" v-show="isEdit">
                    <div class="col-md-12">
                        <div class="btn-group mb-3">
                            <button type="button" class="btn btn-primary btn-sm"><i
                                class="fa fa-edit"></i> Editar
                            </button>
                        </div>
                    </div>
                </div>
            </template>
            <template #body>
                <form @submit.prevent="onSubmit">
                    <TabsContainer>
                        <template #tabs>
                            <li class="nav-item" v-for="(tab, index) in tabs" :key="tab.id">
                                <a :class="['nav-link', { 'active': tab.active }]"
                                   :id="`${tab.id}-tab`"
                                   data-toggle="tab"
                                   :href="tab.href"
                                   role="tab"
                                   :aria-controls="tab.ariaControls"
                                   :aria-selected="tab.ariaSelected"
                                   @click="changeTab(index)">
                                    {{ tab.title }}
                                </a>
                            </li>
                        </template>
                        <template #tab-content>
                            <div v-for="tabContent in tabContents" :key="tabContent.id"
                                 :class="['tab-pane', 'fade', { 'show active': tabContent.active }]"
                                 :id="tabContent.id" role="tabpanel"
                                 :aria-labelledby="tabContent.ariaLabelledby">
                                <component
                                    :is="tabContent.component"
                                    :form="form"
                                    :is-edit="isEdit"
                                ></component>

                            </div>
                        </template>
                    </TabsContainer>

                    <div class="d-flex justify-content-start mt-5">
                        <button type="button" @click="handleBack" class="btn btn-sm btn-secondary me-2">
                            Cancelar
                        </button>
                        <button type="submit" class="btn bt-sm btn-primary">
                            Guardar
                        </button>
                    </div>
                </form>
            </template>
        </CardComponent>
    </div>
</template>

<script>

import Workers from './components/Workers'
import Contract from './components/Contract'
import Salud from './components/Salud'
import Prevision from './components/Prevision'
import AhorroVoluntario from "./components/AhorroVoluntario.vue";
import Contact from "./components/Contact.vue";
import Bank from "./components/Bank.vue";
import CardComponent from "@/components/CardComponent.vue";
import {tabs, tabContentWorkers} from "@/data/WorkerTabs";
import TabsContainer from "@/components/TabsContainer.vue";
import {mapActions, mapState} from "vuex";

export default {
    components: {
        CardComponent,
        Workers,
        Contract,
        Salud,
        Prevision,
        AhorroVoluntario,
        Contact,
        Bank,
        TabsContainer
    },
    props: {
        trabajadorId: {
            type: Number,
            default: 0
        },
        isEdit: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            ActiveTab: 'home',
            title: this.isEdit ? 'Editar Trabajador' : 'Nuevo Trabajador',
            tabs: tabs,
            tabContents: tabContentWorkers,
            form: {
                id: 0,
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
                nacionalidad_id: 3,
                pueblo_originario_id: '',
                empleador_id: '',
                ubicacion_id: '',
                fecha_ingreso: '',
                fecha_antiguidad: '',
                fecha_vencimiento_contrato: '',
                fecha_segundo_vencimiento: '',
                area_id: '',
                cargo_id: '',
                centro_costo: '',
                tipo_contrato: '',
                tipo_jornada: '',
                jornada_excepcional: '',
                //salud
                salud_id: 7,
                tipo_plan_salud: '',
                monto_peso: null,
                monto_uf: null,
                //prevision
                prevision_id: '',
                prevision_inp_id: '',
                tipo_entidad: 'afp',
                contactos: [],
                familiar: [],
                bancos: [],
                ahorros: [],
            }
        }
    },
    computed: {
        ...mapState({
            trabajador: state => state.trabajador.trabajadores,
            error: state => state.trabajador.error
        })
    },
    created() {
        if (this.trabajadorId) {
            //this.fetchTrabajadorById(this.trabajadorId);
            this.cargarDatos();
        }
    },
    mounted() {
        this.setActiveTab(0);
    },
    methods: {
        ...mapActions({
            addTrabajador: 'trabajador/addTrabajador',
            fetchTrabajadorById: 'trabajador/fetchTrabajadorById'
        }),
        changeTab(index) {
            this.setActiveTab(index);
        },
        setActiveTab(index) {
            this.tabs = this.tabs.map((tab, i) => ({...tab, active: i === index}));
            this.tabContents = this.tabContents.map((content, i) => ({...content, active: i === index}));
        },
        async cargarDatos() {
            try {
                const { data, status } = await axios.get('/getTrabajador/' + this.trabajadorId);

                if (status === 200) {
                    // Iterar sobre los campos del formulario
                    for (let key in this.form) {
                        if (data[key] !== undefined) {
                            if (typeof this.form[key] === 'object' && this.form[key] !== null) {
                                if (this.form[key] instanceof Array) {
                                    // Para arrays, asigna directamente si existe, o usa un array vacío
                                    this.form[key] = data[key] || [];
                                } else {
                                    // Para objetos, verifica y asigna subclaves
                                    for (let subKey in this.form[key]) {
                                        this.form[key][subKey] = data[key][subKey] !== undefined ? data[key][subKey] : this.form[key][subKey];
                                    }
                                }
                            } else {
                                // Para campos que no son objetos/array, verifica si es necesario acceder a una subclave
                                this.form[key] = (typeof data[key] === 'object' && data[key] !== null) ? data[key][subKey] || '' : data[key];
                            }
                        } else {
                            // Asigna valores predeterminados si el dato no viene
                            this.form[key] = this.form[key] instanceof Array ? [] : (typeof this.form[key] === 'number' ? 0 : '');
                        }
                    }
                    this.form = {
                        ...this.form, // Mantiene los valores existentes del formulario
                        // Asume que `data` es el objeto recibido de tu API o fuente de datos
                        confirmar_correo: data.correo,
                        pueblo_originario_id: data.pueblo_originario_id || null,

                        // Repite para otros campos que puedan ser null
                    };
                    // Suponiendo que 'contrato' es un objeto con varias propiedades
                    if (data.contrato) {
                        this.form.empleador_id = data.contrato.empleador_id || '';
                        this.form.ubicacion_id = data.contrato.ubicacion_id || '';
                        this.form.fecha_ingreso = data.contrato.fecha_ingreso || '';
                        this.form.fecha_antiguidad = data.contrato.fecha_antiguidad || '';
                        this.form.fecha_vencimiento_contrato = data.contrato.fecha_vencimiento_contrato || '';
                        this.form.fecha_segundo_vencimiento = data.contrato.fecha_segundo_vencimiento || '';
                        this.form.area_id = data.contrato.area_id || '';
                        this.form.cargo_id = data.contrato.cargo_id || '';
                        this.form.centro_costo = data.contrato.centro_costo || '';
                        this.form.tipo_contrato = data.contrato.tipo_contrato || '';
                        this.form.tipo_jornada = data.contrato.tipo_jornada || '';
                        this.form.jornada_excepcional = data.contrato.jornada_excepcional || '';
                       // console.log(data.contrato)
                    }

                    if (data.saludtrabajador) {
                        this.form.salud_id = data.saludtrabajador.salud_id || '';
                        this.form.tipo_plan_salud = data.saludtrabajador.tipo_plan_salud || '';
                        this.form.monto_peso = data.saludtrabajador.monto_peso || '';
                        this.form.monto_uf = data.saludtrabajador.monto_uf || '';
                    }

                    if (data.previsiontrabajador) {
                        this.form.prevision_id = data.previsiontrabajador.prevision_id || '';
                        this.form.prevision_inp_id = data.previsiontrabajador.prevision_inp_id || '';
                        this.form.tipo_entidad = data.previsiontrabajador.tipo_entidad || '';
                    }
                    if (data.contacto) {
                        this.form.contactos = [...data.contacto];
                    } else {
                        this.form.contactos = []; // Asegura que siempre sea un array, incluso si está vacío
                    }

                    if (data.carga_familiares) {
                        this.form.familiar = [...data.carga_familiares];
                    } else {
                        this.form.familiar = []; // Igual aquí
                    }

                    if (data.bancotrabajador) {
                        this.form.bancos = [...data.bancotrabajador];
                    } else {
                        this.form.bancos = []; // Y aquí
                    }
                }
            } catch (error) {
                console.error(error);
            }
        },
        async onSubmit() {
            let formData = new FormData();
            /*for (let key in this.form) {
                formData.append(key, this.form[key] ?? '');
            }*/
            for (let key in this.form) {
                // Verifica si el valor actual es un array
                if (Array.isArray(this.form[key])) {
                    // Convierte el array a un string JSON y lo añade a FormData
                    formData.append(key, JSON.stringify(this.form[key]));
                } else {
                    // Añade los valores no-array directamente a FormData
                    formData.append(key, this.form[key] ?? '');
                }
            }

            // Configuración inicial de Swal
            Swal.fire({
                title: 'Guardando...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading(),
            });

            try {
                // Determina la URL basada en si es edición o adición
                const url = this.trabajadorId ? `/editTrabajador/${this.trabajadorId}` : '/addTrabajador';
                // Incluye el ID del trabajador si es una edición
                if (this.trabajadorId) formData.append('id', this.trabajadorId);

                // Realiza la petición
                const response = await axios.post(url, formData);

                if (response.status === 201) {
                    // Proceso exitoso
                    Swal.fire({
                        icon: 'success',
                        title: 'Guardado exitosamente',
                        showConfirmButton: true,
                        confirmButtonText: 'Salir',
                    }).then((result) => {
                        if (result.isConfirmed || result.dismiss === Swal.DismissReason.timer) {
                            window.location.href = '/trabajadores';
                        }
                    });
                } else {
                    // Manejo de otros códigos de estado HTTP
                    throw new Error('La respuesta del servidor no fue la esperada.');
                }
            } catch (error) {
                // Mejora en el manejo de errores
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error al guardar',
                    text: error.response?.data?.message || error.message || 'Ha ocurrido un error al guardar los datos.',
                });
            }
        },
        handleBack() {
            window.location.href = '/trabajadores';
        }

    },

}
</script>
