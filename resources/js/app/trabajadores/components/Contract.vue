<template>
    <div class="row my-5 mx-5">
        <!-- Empleador -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Empleador</label>
            <select v-model="form.empleador_id" class="form-select form-select-solid">
                <option value="">---Seleccione---</option>
                <option v-for="empleador in empleadores" :key="empleador.id" :value="empleador.id">{{ empleador.nombre_empleador }}</option>
            </select>
        </div>

        <!-- Ubicaciones -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Ubicaciones</label>
            <select v-model="form.ubicacion_id" class="form-select form-select-solid">
                <option value="">---Seleccione---</option>
                <option v-for="ubicacion in ubicaciones" :key="ubicacion.id" :value="ubicacion.id">{{ ubicacion.nombre_ubicacion }}</option>
            </select>
        </div>

        <!-- Fecha de Ingreso -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Fecha de Ingreso</label>
            <input class="form-control form-control-solid" type="date" v-model="form.fecha_ingreso" :disabled="isDisabledInput" />
        </div>

        <!-- Fecha de Antigüedad -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Fecha de Antigüedad</label>
            <input class="form-control form-control-solid" type="date" v-model="form.fecha_antiguidad" :disabled="isDisabledInput" />
        </div>

        <!-- Fecha Primer Vencimiento -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Fecha Primer Vencimiento</label>
            <input class="form-control form-control-solid" type="date" v-model="form.fecha_vencimiento_contrato" :disabled="isDisabledInput" />
        </div>

        <!-- Fecha Segundo Vencimiento -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Fecha Segundo Vencimiento</label>
            <input class="form-control form-control-solid" type="date" v-model="form.fecha_segundo_vencimiento" :disabled="isDisabledInput" />
        </div>

        <!-- Áreas -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Áreas</label>
            <select v-model="form.area_id" class="form-select form-select-solid">
                <option value="">---Seleccione---</option>
                <option v-for="area in areas" :key="area.id" :value="area.id">{{ area.descripcion_area }}</option>
            </select>
        </div>

        <!-- Cargos -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Cargos</label>
            <select v-model="form.cargo_id" class="form-select form-select-solid">
                <option value="">---Seleccione---</option>
                <option v-for="cargo in cargos" :key="cargo.id" :value="cargo.id">{{ cargo.nombre_cargo }}</option>
            </select>
        </div>

        <!-- Centro de Costo -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Centro de Costo</label>
            <select v-model="form.centro_costo" class="form-select form-select-solid">
                <option value="">---Seleccione---</option>
                <option v-for="centro in centro_costo" :key="centro" :value="centro">{{ centro }}</option>
            </select>
        </div>

        <!-- Tipo de Contrato -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Tipo de Contrato</label>
            <select v-model="form.tipo_contrato" class="form-select form-select-solid">
                <option value="">---Seleccione---</option>
                <option v-for="tipo in tipo_contrato" :key="tipo" :value="tipo">{{ tipo }}</option>
            </select>
        </div>
        <!-- Tipo de Jornada con manejo especial para Jornada Excepcional -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Tipo de Jornada</label>
            <select v-model="form.tipo_jornada" class="form-select form-select-solid" @change="checkJornadaExcepcional">
                <option value="">---Seleccione---</option>
                <option v-for="tipo in tipo_jornada" :key="tipo" :value="tipo">{{ tipo }}</option>
            </select>
        </div>

        <!-- Jornada Excepcional, mostrado condicionalmente -->
        <div v-if="isJornadaExcepcional" class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Jornada Excepcional</label>
            <select v-model="form.jornada_excepcional" class="form-select form-select-solid">
                <option value="">---Seleccione---</option>
                <option v-for="tipo in jornada_excepcional" :key="tipo" :value="tipo">{{ tipo }}</option>
            </select>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
export default {
    name: 'Contract',
    props: {
       form:{
           type: Object,
           required: true
       }
    },
    data() {
        return {
            // Estados equivalentes a los useState de React
          /*  form: {
                empleador_id: '',
                ubicacion_id: '',
                fecha_ingreso: '',
                fecha_antiguedad: '',
                fecha_vencimiento_contrato: '',
                fecha_segundo_vencimiento: '',
                area_id: '',
                cargo_id: '',
                centro_costo: '',
                tipo_contrato: '',
                tipo_jornada: '',
                jornada_excepcional: '',
            },*/
            isJornadaExcepcional: false,
            isDisabledInput: false,
            tipo_jornada: ['Jornada completa', 'Part Time', 'Excepcional', 'Turno Rotativo', 'Bisemanal'],
            jornada_excepcional: ['7x7', '10x4', '20x10'],
            centro_costo: ['Producción', 'Administración', 'Ventas'],
            tipo_contrato: ['Contrato a Plazo Fijo', 'Contrato Indefinido', 'Contrato por obra o faena', 'Contrato por honorario', 'Contrato practicante'],

        };
    },
    computed: {
        // Aquí mapearías los estados globales que necesites
        ...mapState({
            // Por ejemplo, si necesitas el listado de empleadores
            empleadores: state => state.empleadores.empleadores,
            ubicaciones: state => state.ubicaciones.ubicaciones,
            areas: state => state.areas.areas,
            cargos: state => state.cargos.cargos,
            // Continuar con los demás estados necesarios
        }),
    },
    methods: {
        ...mapActions({
            // Aquí mapearías las acciones globales que necesites
            loadEmpleadores: 'empleadores/fetchEmpleadores',
            loadUbicaciones: 'ubicaciones/fetchUbicaciones',
            loadAreas: 'areas/fetchAreas',
            loadCargos: 'cargos/fetchCargos',
            // Continuar con las demás acciones necesarias
        }),
        checkJornadaExcepcional() {
            this.isJornadaExcepcional = this.form.tipo_jornada === 'Excepcional';
        },

        // Aquí añadirías los métodos para cargar los datos dinámicos (empleadores, ubicaciones, etc.)
    },
    watch: {
        'form.fecha_ingreso': function(newVal) {
            if (newVal) {
                let fechaIngreso = new Date(newVal);

                // Add 3 months to fecha_ingreso for fecha_vencimiento_contrato
                fechaIngreso.setMonth(fechaIngreso.getMonth() + 3);
                this.form.fecha_vencimiento_contrato = fechaIngreso.toISOString().split('T')[0];

                // Add 15 days to fecha_vencimiento_contrato for fecha_segundo_vencimiento
                fechaIngreso.setDate(fechaIngreso.getDate() + 15);
                this.form.fecha_segundo_vencimiento = fechaIngreso.toISOString().split('T')[0];
            }
        }
    },
    mounted() {
        // Aquí invocarías los métodos de carga de datos, similar a useEffect en React
        this.loadEmpleadores();
        this.loadUbicaciones();
        this.loadAreas();
        this.loadCargos();
        // Continuar con las demás cargas necesarias
    }
};
</script>
