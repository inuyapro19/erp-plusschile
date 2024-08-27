<template>
    <div>
        <CardComponent>
            <template #header>
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group mb-4">
                            <a href="/vaciones-trabajador/create" class="btn btn-primary btn-sm"> <i
                                class="fa fa-plus-circle"></i> Agregar</a>
                            <button class="btn btn-success btn-sm" @click="filtro = !filtro"><i
                                class="fa fa-filter"></i> Filtrar
                            </button>
                        </div>
                    </div>
                </div>
            </template>

            <template #body>
                <DataTable
                    :columns="columns"
                    :items="vacaciones.data"
                    :isCheck="false"

                >
                    <template #filtros>
                        <tr v-show="filtro">
                            <td colspan="3">
                                <select
                                    name="trabajador_id"
                                    class="form-select mb-2"
                                    id="trabajador_id"
                                    data-control="select2"
                                    data-placeholder="Seleccione trabajador"
                                    data-allow-clear="true"
                                >
                                    <option value="">--------</option>
                                    <option
                                        v-for="({id,rut,primer_nombre, segundo_nombre,primer_apellido,segundo_apellido}, index) in trabajadores"
                                        :value="id">
                                        {{ rut + ' - ' + primer_nombre + ' ' + primer_apellido + ' ' + segundo_apellido }}
                                    </option>
                                </select>
                            </td>
                            <td>
                                <select name="empresas" id="empresas" @change.prevent="getVacaciones()"
                                        v-model="empleador_id" class="form-select form-select-sm">
                                    <option value="" selected>----Empresas----</option>
                                    <option v-for="(empleador, index) in empleadores" :value="empleador.id">
                                        {{ empleador.nombre_empleador }}
                                    </option>
                                </select>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </template>
                    <template #actions="{item}">
                        <div class="btn-group">
                            <button @click.prevent="abrir_vaciones_editar(item.id)" class="btn btn-primary btn-sm"><i
                                class="fa fa-edit"></i></button>
                        </div>

                    </template>
                </DataTable>
                <div class="row">
                    <div class="col-md-1">

                    </div>

                    <div class="col-md-11">
                        <paginate :pagination="vacaciones" :onPageChange="getVacaciones"></paginate>
                    </div>

                </div>
            </template>

        </CardComponent>


        <!-- Modal -->
        <div class="modal fade" id="LicenciaMedicaModal" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detalle de vacaciones</h5>
                        <button class="btn btn-danger btn-sm" @click.prevent="editar_licencia()">Editar</button>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="nombre">RUT</label>
                                <input type="text" v-model="rut" id="rut" class="form-control" :disabled="true">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" v-model="nombre_trabajador" id="nombre" class="form-control"
                                       :disabled="true">
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="dias_habiles_solicitados">Dias Habiles Solicitados</label>
                                <input type="number" v-model="dias_habiles_solicitados" :disabled="editar"
                                       id="dias_habiles_solicitados" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="fecha_primer_dia">Fecha primer día</label>
                                <input type="date" v-model="fecha_primer_dia" id="fecha_primer_dia" :disabled="editar"
                                       class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="saldo_previo_vacaciones">Saldo previo vacaciones</label>
                                <input type="number" v-model="saldo_previo_vacaciones" id="saldo_previo_vacaciones"
                                       :disabled="editar" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="saldo_despues_vacacaciones">Saldo despues vacaciones</label>
                                <input type="number" v-model="saldo_despues_vacaciones" id="saldo_despues_vacacaciones"
                                       :disabled="editar" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="dias_corridos_del_periodo_de_vac">Días corridos del periodo de Vac.</label>
                                <input type="number" v-model="dias_corridos_del_periodo_de_vac"
                                       id="dias_corridos_del_periodo_de_vac" :disabled="editar" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="fecha_ultimo_dia">Fecha ultimo dia</label>
                                <input type="date" v-model="fecha_ultimo_dia" id="fecha_ultimo_dia" :disabled="editar"
                                       class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="fecha_corte_calculo1">Fecha corte calculo #1</label>
                                <input type="date" v-model="fecha_corte_calculo1" id="fecha_corte_calculo1"
                                       :disabled="editar" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="fecha_corte_calculo2">Fecha corte calculo #2</label>
                                <input type="date" v-model="fecha_corte_calculo2" id="fecha_corte_calculo2"
                                       :disabled="editar" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button :disabled="editar" @click.prevent="enviarFormulario()" class="btn btn-success">Guardar
                        </button>
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import CardComponent from "@/components/CardComponent.vue";
import Select2 from "@/components/Form/Select2.vue";
import DataTable from "@/components/DataTable.vue";
import paginate from "@/components/paginate.vue";

export default {
    components: {
        CardComponent,
        Select2,
        DataTable,
        paginate
    },
    data() {
        return {
            vacaciones: [],
            trabajadores: [],
            dias_habiles_solicitados: 0,
            fecha_primer_dia: '',
            saldo_previo_vacaciones: 0,
            saldo_despues_vacaciones: 0,
            dias_corridos_del_periodo_de_vac: 0,
            fecha_ultimo_dia: '',
            fecha_corte_calculo1: '',
            fecha_corte_calculo2: '',
            trabajador_id: 0,
            estado: '',
            licencias: [],
            trabajador_selecionado: [],
            rut: '',
            nombre_trabajador: '',
            cargo_trabajador: '',
            nombre_empleador: '',
            ubicacion_trabajador: '',
            empleadores: [],
            empleador_id: 0,
            editar: true,
            page: 0,
            page_class: 'page-item active',
            filtro: false,
            columns:[
                {key:'VACACIONES_ID',label:'ID'},
                {key:'RUT',label:'RUT'},
                {key:'NOMBRE_COMPLETO',label:'Nombre'},
                {key:'NOMBRE_EMPLEADOR',label:'Empleador'},
                {key:'DIAS_HABILES_SOLICITADO',label:'Dias Habiles'},
                {key:'FECHA_PRIMER_DIA',label:'Fecha Primer día'},
                {key:'SALDO_PREVIO_VACACIONES',label:'Saldo Previo'},
                {key:'SALDO_DESPUES_VACACIONES',label:'Saldo Después'},
                {key:'DIAS_CORRIDO_DEL_PERIODO_VACACIONES',label:'Días Corrido Vacaciones'},
                {key:'FECHA_ULTIMO_DIA',label:'Fecha ultimo dia'},
                {key:'FECHA_CALCULO_CORTE_1',label:'Fecha corte calculo 1'},
                {key:'FECHA_CORTE_2',label:'Fecha corte calculo 2'},
                {key:'ESTADO_VACACIONES',label:'Estado'},
            ]


        }
    },
    mounted() {
        this.getVacaciones()
        this.getTrabajadores()
        this.cargarEmpleador()
    },
    updated() {
        // this.refrescar()
        $('#trabajador_id').on('select2:select', this.onSelectTraabajador);
    },
    methods: {
        refrescar: function () {
            //this.$refs.categorias.selectpicker('refresh')
            $(this.$refs.trabajadores).selectpicker('refresh')
            // $(this.$refs.buses).selectpicker('refresh')
        },
        onSelectTraabajador: function (e) {
            this.trabajador_id = parseInt(e.params.data.id);
            //transformalo en int
            //  this.trabajador_id = parseInt(this.trabajador_id)
            this.getVacaciones()
        },
        async getVacaciones( page = 1) {
            try {
                let url = '/getVacaciones?opciones=get'

                if (this.trabajador_id > 0) {

                    url = url + '&trabajador_id=' + this.trabajador_id

                }

                if (this.empleador_id > 0) {
                    url = url + '&empleador_id=' + this.empleador_id
                }

                if (page > 0) {
                    url = url + '&page=' + page
                }

                const {data, status} = await axios.get(url)

                if (status == 200) {
                    this.vacaciones = data
                }

            } catch (e) {
                console.log(e)
            }
        },
        async getTrabajadores() {
            try {
                const {data, status} = await axios.get('/lista-trabajadores')

                if (status === 200) {
                    this.trabajadores = data
                }
            } catch (error) {
                console.log(error)
            }

        },
        async cargarEmpleador() {
            try {

                const {data, status} = await axios.get('/empleador')

                if (status == 200) {
                    this.empleadores = data
                }

            } catch (e) {
                console.log(e)
            }
        },
        abrir_vaciones_editar(id) {
            try {
                let vacaciones = this.vacaciones.data.find((item) => item.id === id)
                this.dias_habiles_solicitados = vacaciones.DIAS_HABILES_SOLICITADO
                this.fecha_primer_dia = vacaciones.FECHA_PRIMER_DIA
                this.saldo_previo_vacaciones = vacaciones.SALDO_PREVIO_VACACIONES
                this.saldo_despues_vacaciones = vacaciones.SALDO_DESPUES_VACACIONES
                this.dias_corridos_del_periodo_de_vac = vacaciones.DIAS_CORRIDO_DEL_PERIODO_VACACIONES
                this.fecha_ultimo_dia = vacaciones.FECHA_ULTIMO_DIA
                this.fecha_corte_calculo1 = vacaciones.FECHA_CALCULO_CORTE_1
                this.fecha_corte_calculo2 = vacaciones.FECHA_CORTE_2
                this.estado = vacaciones.ESTADO_VACACIONES
                this.rut = vacaciones.RUT
                this.nombre_trabajador = vacaciones.NOMBRE_COMPLETO
                this.nombre_empleador = vacaciones.NOMBRE_EMPLEADOR
                this.id = vacaciones.VACACIONES_ID
                this.trabajador_id = vacaciones.ID_TRABAJADOR

                $('#LicenciaMedicaModal').modal('show')
            } catch (e) {
                console.log(e)
            }


        },
        editar_licencia: function () {
            if (this.editar == true) {
                this.editar = false
            } else {
                this.editar = true
            }
        },
        async enviarFormulario() {
            let formData = new FormData
            let id = this.id
            formData.append('dias_habiles_solicitados', this.dias_habiles_solicitados)
            formData.append('fecha_primer_dia', this.fecha_primer_dia)
            formData.append('saldo_previo_vacaciones', this.saldo_previo_vacaciones)
            formData.append('saldo_despues_vacaciones', this.saldo_despues_vacaciones)
            formData.append('dias_corridos_del_periodo_de_vac', this.dias_corridos_del_periodo_de_vac)
            formData.append('fecha_ultimo_dia', this.fecha_ultimo_dia)
            formData.append('fecha_corte_calculo1', this.fecha_corte_calculo1)
            formData.append('fecha_corte_calculo2', this.fecha_corte_calculo2)

            formData.append('trabajador_id', this.trabajador_id)

            axios.post('/vaciones-trabajador/' + id, formData).then((res) => {
                this.respuesta = true
                this.alerta = 'alert-success'
                this.mensajes = 'Vacaciones agregada exitosamente'
                this.$swal('Vacaciones Agregadas exitosamente')
                $('#LicenciaMedicaModal').modal('hide')
                this.getVacaciones();
                console.log(res)
            }).catch((error) => {
                this.respuesta = true
                this.alerta = 'alert-danger'
                this.mensajes = 'Error al enviar el formulario'
                this.errorsClass = 'form-control is-invalid';
                console.log(error)
            })

        },
        getPaginate: function (page_number) {
            this.page = page_number
            this.page_class = 'page-item active'
            this.getVacaciones()
        }
    },
}
</script>

<style scoped>
th {
    font-weight: bolder !important;
    color: #fff !important;
}

th a:hover {
    cursor: pointer;
    color: #222222 !important;
}

thead tr th {
    background-color: #D3B560;
    color: white;
}
</style>
