<template>
    <div>
        <table>
            <thead>
            <tr>
                <th>N°</th>
                <th>ESTADO</th>
                <th>MARCA</th>
                <th>MODELO</th>
                <th>PRESIÓN (PSI)</th>
                <th>PROFUNDIDAD (MILIMETROS)</th>
                <th>TORQUE (NM)</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in items" :key="index">
                <td>{{ index + 1 }}</td>
                <td>{{ item.estado }}</td>
                <td>{{ item.marca }}</td>
                <td>{{ item.modelo }}</td>
                <td>{{ item.presion }}</td>
                <td>
                    <span>{{ item.profundidadInterior }}</span>
                    <span>{{ item.profundidadMedial }}</span>
                    <span>{{ item.profundidadExterior }}</span>
                </td>
                <td>{{ item.torque }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: 'TablaComponente',
    data() {
        return {

            items: [
                // Ejemplo de objeto de fila
                { estado: 'Bueno', marca: 'Marca1', modelo: 'Modelo1', presion: 32, profundidadInterior: 3, profundidadMedial: 5, profundidadExterior: 7, torque: 100 },

            ]
        };
    }
};
</script>

<style>
/* Agrega estilos aquí si es necesario */
table {
    width: 100%;
    border-collapse: collapse;
}
th, td {
    border: 1px solid black;
    padding: 8px;
    text-align: left;
}
</style>

