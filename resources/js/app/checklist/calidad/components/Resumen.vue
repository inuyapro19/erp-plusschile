<template>
    <div>
        <h1>Resumen</h1>
<!--        <div class="resumen grid-container">
            <div class="grid-item">
                <p>Bus: {{ busDescripcion }}</p>
            </div>
            <div class="grid-item">
                <p>Fecha: {{ fecha }}</p>
            </div>
            <div class="grid-item">
                <p>Tipo de servicio: {{ servicio }}</p>
            </div>
            <div class="grid-item">
                <p>Destino: {{ destinoCiudad }}</p>
            </div>
            <div class="grid-item">
                <p>Hora de salida: {{ hora_salida }}</p>
            </div>

        </div>-->
        <div class="ficha-resumen">
            <div class="ficha-resumen-header">
                <div>
                    <div class="label">BUS:</div>
                    <div class="value"> {{ busDescripcion }}</div>
                </div>
                <div>
                    <div class="label">FECHA:</div>
                    <div class="value">{{ fecha }}</div>
                </div>
                <div>
                    <div class="label">HORA SALIDA:</div>
                    <div class="value">{{ hora_salida }}</div>
                </div>
                <div>
                    <div class="label">TIPO SERVICIO:</div>
                    <div class="value">{{servicio}}</div>
                </div>
                <div>
                    <div class="label">CIUDAD ORIGEN:</div>
                    <div class="value">{{ destinoCiudad }}</div>
                </div>
                <div>
                    <div class="label">CIUDAD DESTINO:</div>
                    <div class="value">{{ destinoCiudad }}</div>
                </div>

            </div>
        </div>


        <div class="resumen">
            <h4>Total: <span class="badge badge-secondary">{{ cantidadTotal }}</span></h4>
            <h4>Aprobados: <span class="badge badge-success">{{ cantidadAprobados }}</span></h4>
            <h4>Aprobados con Observaciones: <span
                class="badge badge-warning">{{ cantidadAprobadosConObservaciones }}</span></h4>
            <h4>Rechazados: <span class="badge badge-danger">{{ cantidadRechazados }}</span></h4>
            <h4>NA: <span class="badge badge-info">{{ cantidadNA }}</span></h4>
        </div>
        <div v-if="respuestasAprobadasConObservaciones.length > 0">
            <h1 class="mb-5">Aprobados con observaciones</h1>
            <table class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th>ID</th>
                    <th>Item</th>
                    <th>Respuesta</th>
                    <th>Observaciones</th>
                    <th>Resultado</th>
                    <th>Area</th>
                </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                <tr v-for="item in respuestasAprobadasConObservaciones" :key="item.id">
                    <td>{{ item.id }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.respuesta }}</td>
                    <td>{{ item.observaciones }}</td>
                    <td>{{ item.respuesta_add }}</td>
                    <td>{{item.area_name}}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div v-if="respuestasRechazadas.length > 0">
            <h1 class="mb-5">Rechazados</h1>

            <table class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th>ID</th>
                    <th>Item</th>
                    <th>Respuesta</th>
                    <th>Observaciones</th>
                    <th>Resultado</th>
                    <th>Area</th>
                </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                <tr v-for="item in respuestasRechazadas" :key="item.id">
                    <td>{{ item.id }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.respuesta }}</td>
                    <th>{{ item.observaciones }}</th>
                    <td>{{ item.respuesta_add }}</td>
                    <td>{{item.area_name}}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div v-if="itemResidencias.length > 0 || respuestasRechazadas.length > 0 || respuestasAprobadasConObservaciones.length > 0 ">
            <h1 class="mb-5">Items con reincidencias</h1>
            <data-table
                :items="itemResidencias"
                :columns="columnas"
            >
            </data-table>

        </div>

        <div v-if="observaciones.length > 0">
            <h1 class="mb-5">Observaciones</h1>
            <table class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th>Nº</th>
                    <th>Observaciones</th>
                </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                <tr v-for="(observacion,index) in observaciones">
                    <td>{{index +1}}</td>
                    <td>{{ observacion }}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div v-if="respuestasRechazadas.length > 0 || respuestasAprobadasConObservaciones.length > 0">
            <div class="col-md-8 mb-5">
                <label class="fs-6 fw-semibold mb-2" for="">Areas</label>
                <select v-model="area_id" class="form-select form-select-solid">
                    <option v-for="area in areasConIncidencias" :value="area.id">{{ area.name }}</option>
                </select>
            </div>
            <div class="col-md-8 mb-5">
                <label class="fs-6 fw-semibold mb-2" for="">Trabajador</label>
                <v-select
                    :options="formattedTrabajadores"
                    placeholder="Trabajadores"
                    class="form-control form-control-solid"
                    :reduce="trabajador => trabajador.id" v-model="trabajador_id"
                    style="padding:0px !important"
                ></v-select>
            </div>
            <div class="col-md-5">
                <label for="tiene_discapacidad" class="fs-6 fw-semibold mb-2">¿Acepta Firmar?</label>
                <div class="form-check form-switch form-check-custom form-check-solid">
                    <input class="form-check-input"
                           type="checkbox"
                           id="tiene_discapacidad"
                           v-model="isAgreeSigned"
                    />
                    <label class="form-check-label fw-semibold text-gray-400 ms-3" for="status"></label>
                </div>
            </div>

            <div v-if="isAgreeSigned">
                <div class="col-md-8 mb-5">
                    <label class="fs-6 fw-semibold mb-2">Contraseña</label>
                    <div class="input-group">
                        <input :type="showPassword ? 'text' : 'password'" v-model="password"
                               class="form-control form-control-solic">
                        <button class="btn btn-outline-secondary" type="button"
                                @click="showPassword = !showPassword">
                            <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                        </button>
                    </div>
                    <p class="text-danger" v-if="passwordError">{{ passwordError }}</p>
                </div>
                <div class="col-md-8 mb-5">
                    <label class="fs-6 fw-semibold mb-2">Repetir Contraseña</label>
                    <div class="input-group">
                        <input :type="showPassword ? 'text' : 'password'" v-model="password_repeat"
                               class="form-control form-control-solic">
                        <button class="btn btn-outline-secondary" type="button"
                                @click="showPassword = !showPassword">
                            <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                        </button>
                    </div>
                </div>
            </div>


            <div class="col-md-8 mb-5" v-else>
                <label class="fs-6 fw-semibold mb-2" for="">Observación</label>
                <textarea class="form-control form-control-solic" v-model="observacion" rows="3"></textarea>
            </div>

            <div class="col-md-8 mb-5">
                <button type="button" @click="addFirmante"
                        class="btn btn-primary">Firmar</button>
            </div>

            <h1>Usuario que Firmaron</h1>
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Area</th>
                        <th>Fecha</th>
                        <th>Observaciones</th>
                        <th>Estado</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td>{{ user.nombre + ' ' + user.apellidos }}</td>
                        <td>{{ user.area_name }}</td>
                        <td>{{ user.fecha }}</td>
                        <td>{{user.observaciones}}</td>
                        <td><span class="badge badge-success">{{ user.firmado === 1 ? 'firmado' : 'no firmado' }}</span></td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</template>

<script>
import DataTable from "@/components/DataTable.vue";
export default {
    components: {
        DataTable
    },
    props:{
        isEdit: {
            type: Boolean,
            default: false
        },
        bus_id: {
            type: Number,
            required: true
        },
        buses: {
            type: Array,
            required: true
        },
        fecha: {
            type: String,
            required: true
        },
        modelo: {
            type: String,
            required: true
        },
        marca: {
            type: String,
            required: true
        },
        isProgramacion: {
            type: Boolean,
            default: false
        },
        hora_salida: {
            type: String,
            default: '00:00'
        },
        servicio:{
            type: String,
            default: 'SIN PROGRAMACION'
        },
        servicios: {
            type: Array,
            default: () => []
        },
        origen_id: {
            type: Number,
            default: null
        },
        destino_id: {
            type: Number,
            required: true
        },
        destinos: {
            type: Array,
            required: true
        },
        numero_pisos: {
            type: Number,
            default: 2
        },
        respuestas: {
            type: Object,
            required: true
        },
        observaciones: {
            type: Array,
            default: () => []
        },
        users:{
            type: Array,
            default: () => []
        },
        imagePreviews: {
            type: Object,
            default: () => ({})
        },
        trabajadores: {
            type: Array,
            default: () => []
        },
        trabajador_id: {
            type: Number,
            default: null
        },
        password: {
            type: String,
            default: ''
        },
        password_repeat:{
            type: String,
            default: ''
        },
        showPassword: {
            type: Boolean,
            default: false
        },
        isAgreeSigned: {
            type: Boolean,
            default: false
        },
        observacion:{
            type: String,
            default: ''
        },
        passwordError: {
            type: String,
            default: ''
        },
        area_id: {
            type: Number,
            default: null
        },
        areas: {
            type: Array,
            default: () => []
        },
        itemResidencias: {
            type: Array,
            default: () => []
        },
        columnas: {
            type: Array,
            default: () => []
        }
    },
    computed: {
        busDescripcion() {
            const bus = this.buses.find(bus => bus.id === this.bus_id);
            return bus ? `${bus.numero_bus}-${bus.patente}` : 'Bus no encontrado';
        },
        destinoCiudad() {
            const destino = this.destinos.find(destino => destino.id === this.destino_id);
            return destino ? destino.ciudad : 'Destino no encontrado';
        },
        cantidadTotal() {
            // Retorna la cantidad de llaves en el objeto 'respuestas', que representa el número total de respuestas.
            return Object.keys(this.respuestas).length;
        },
        cantidadAprobados() {
            return Object.values(this.respuestas).filter(item => item.respuesta === 'SI').length;
        },
        cantidadAprobadosConObservaciones() {
            // Filtra las respuestas con 'NO' y 'critical' igual a 'approved with observation'.
            return Object.values(this.respuestas).filter(item => item.respuesta === 'NO' || item.valor === 'NO' && item.critical === 'approved with observation').length;
        },
        cantidadRechazados() {
            // Filtra las respuestas con 'NO' y 'critical' igual a 'refused'.
            return Object.values(this.respuestas).filter(item => item.respuesta === 'NO' || item.valor === 'NO' && item.critical === 'refused').length;
        },

        cantidadNA() {
            return Object.values(this.respuestas).filter(item => item.respuesta === 'NA').length;
        },
        //devuelve solo la rechazadas para el resumen
        respuestasRechazadas() {
            // Filtra y retorna respuestas 'NO' con 'critical' igual a 'refused', ordenadas por 'area_id' ascendente.
            return Object.values(this.respuestas).filter(item => (item.respuesta === 'NO' || item.valor === 'NO') && item.critical === 'refused')
                .sort((a, b) => a.area_id - b.area_id);
        },
        respuestasAprobadasConObservaciones() {
            // Filtra y retorna respuestas 'NO' con 'critical' igual a 'approved with observation', ordenadas por 'area_id' ascendente.
            return Object.values(this.respuestas).filter(item => (item.respuesta === 'NO' || item.valor === 'NO') && item.critical === 'approved with observation')
                .sort((a, b) => a.area_id - b.area_id);
        },
        //sacar solo las areas que tienen incidencias para quitar las areas[] que no tienen incidencias
        areasConIncidencias() {
            // Obtener los IDs de las áreas con incidencias desde respuestas
            const areasConIncidenciasIds = Object.values(this.respuestas).reduce((acc, item) => {
                if ((item.respuesta === 'NO' || item.valor === 'NO') && !acc.includes(item.area_id)) {
                    acc.push(item.area_id);
                }
                return acc;
            }, []);

            // Filtrar `areas` para incluir solo aquellas con incidencias
            return this.areas.filter(area => areasConIncidenciasIds.includes(area.id));
        },
        formattedTrabajadores() {
            return this.trabajadores.map((trabajador) => {
                return {
                    id: trabajador.id,
                    label: trabajador.rut + ' - ' + trabajador.name + ' ' + trabajador.apellidos
                };
            });
        },
    },
    watch:{
        area_id(newAreaId){
            this.$emit('update', { prop: 'area_id', value: newAreaId });
        },
        password(newVal) {
           this.$emit('update', { prop: 'password', value: newVal });
        },
        password_repeat(newVal) {
            this.$emit('update', { prop: 'password_repeat', value: newVal });
        },
        trabajador_id(newTrabajadorId) {
            this.$emit('update', { prop: 'trabajador_id', value: newTrabajadorId });
        },
    },
    methods:{
        addFirmante(){
            this.$emit('addFirmante');
        }
    }

};
</script>
<style scoped>
.content-item {
    width: 300px !important;
    margin-bottom: 20px;
}

.content-item label {
    font-size: 13px;
    font-weight: 600;
}

.disabled {
    cursor: not-allowed;
    pointer-events: all !important;
}

.my-swal {
    background-color: #f9f9f9;
}

.my-swal-title {
    color: #333;
    font-size: 24px;
}

.my-swal-content {
    color: #666;
}

.my-swal-confirm-button {
    background-color: #3085d6;
    color: #fff;
}

.grid-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* 3 columnas de igual anchura */
    grid-gap: 20px; /* Espacio entre las celdas de la grid */
}

.grid-item {
    /* Estilos adicionales para los elementos de la grid, si es necesario */
}

.grid-item-full {
    grid-column: 1 / -1; /* Hace que las observaciones ocupen todas las columnas */
}

.badge-secondary {
    background-color: #6c757d;
}

.badge-success {
    background-color: #28a745;
}

.badge-warning {
    background-color: #ffc107;
}

.badge-danger {
    background-color: #dc3545;
}

.badge-info {
    background-color: #17a2b8;
}

.vs__dropdown-toggle {
    padding: .775rem 1rem !important;
    font-size: 1rem !important;
}
.ficha-resumen {
    display: flex;
    flex-direction: column;
    flex-wrap: wrap;
    justify-content: space-between;
    width: 100%;
    margin: 20px auto;

}
.ficha-resumen-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}
.ficha-resumen-header > div {
    flex: 1;
    text-align: left;
}
.ficha-resumen-header > div:not(:last-child) {
    margin-right: 10px;
}
.label {
    font-weight: bold;
    margin-bottom: 2px;
}
.value {
    font-size: 1em;
}
</style>
