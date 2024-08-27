<template>
    <div>
        <h1>Resumen</h1>
        <div class="resumen grid-container">
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
            <div class="grid-item-full">
                <p>Observaciones: {{ observaciones }}</p>
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
                    <th>Resultado</th>
                </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                <tr v-for="item in respuestasAprobadasConObservaciones" :key="item.id">
                    <td>{{ item.id }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.respuesta }}</td>
                    <td>{{ item.observaciones }}</td>
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
                    <th>Resultado</th>
                </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                <tr v-for="item in respuestasRechazadas" :key="item.id">
                    <td>{{ item.id }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.respuesta }}</td>
                    <td>{{ item.respuesta_add }}</td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
</template>

<script>
export default {
    props: {
        busDescripcion: {
            type: String,
            required: true
        },
        fecha: {
            type: String,
            required: true
        },
        servicio: {
            type: String,
            required: true
        },
        destinoCiudad: {
            type: String,
            required: true
        },
        hora_salida: {
            type: String,
            required: true
        },
        observaciones: {
            type: String,
            required: true
        },
        cantidadTotal: {
            type: Number,
            required: true
        },
        cantidadAprobados: {
            type: Number,
            required: true
        },
        cantidadAprobadosConObservaciones: {
            type: Number,
            required: true
        },
        cantidadRechazados: {
            type: Number,
            required: true
        },
        cantidadNA: {
            type: Number,
            required: true
        },
        respuestasAprobadasConObservaciones: {
            type: Array,
            required: true
        },
        respuestasRechazadas: {
            type: Array,
            required: true
        }
    }
}
</script>
