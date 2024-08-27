<template>
    <div>

        <table class="table table-striped table-condensed">
            <thead>
                <th>Asunto</th>
                <th>Tipo Solicitud</th>
                <th>Comentario</th>
                <th>Fecha Solicitud</th>
                <th>Estado</th>
                <th>Acciones</th>
            </thead>
            <tbody>
                <tr v-for="(solicitud, index) in solicitudes">
                    <td>{{solicitud.asunto}}</td>
                    <td>{{solicitud.tipo_solicitud}}</td>
                    <td v-html="solicitud.comentario"></td>
                    <td>{{solicitud.created_at | moment("DD/MM/YYYY")}}</td>
                    <td>{{solicitud.estado}}</td>
                    <td>
                        <a :href="'/solicitude-trabajador/'+solicitud.id" class="btn btn-success btn-sm" title="Ver Respuestas"><i class="fa fa-arrow-right"></i></a>
                    </td>
                </tr>
            </tbody>

        </table>


    </div>
</template>

<script>
export default {
    data() {
        return {
            solicitudes:[]
        }
    },
    mounted() {
        this.cargarMisSolicitudes()
    },
    methods:{
        cargarMisSolicitudes:function (){
            axios.get('/getMisSolicitudes').then((res)=>{
                this.solicitudes = res.data
            }).catch((error)=>{
                console.log(error)
            })
        }
    }
}
</script>

<style scoped>

</style>
