<template>
    <div>
        <div class="row">
            <div class="filtro mt-2 mb-3 col-md-4">
                <label for="">Estado</label>
                <select name="estado" id="estado" v-model="estado" @change.prevent="cambiar_estado" class="form-control">
                    <option value="">-----------</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="en proceso">En Proceso</option>
                    <option value="finalizada">Finalizado</option>
                </select>
            </div>
            <div class="filtro mt-2 mb-3 col-md-4">
                <label for="">Tipo de solicitud</label>
                <select name="tipo_solicitud" id="tipo_solicitud" v-model="tipo_solicitud" @change.prevent="cambioTipoSolicitud" class="form-control">
                    <option value="">-----------</option>
                    <option v-for="(tipo_solicitud, index) in arrayTipoSolicitud" :value="tipo_solicitud">{{tipo_solicitud}}</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <button class="btn btn-success" @click.prevent="obtenerSolicitudes()">Reset</button>
            </div>
        </div>
        <table class="table table-striped table-condensed">
            <thead>
                <th>Trabajador</th>
                <th>Asunto</th>
                <th>Tipo Solicitud</th>
                <th>Comentario</th>
                <th>Fecha Solicitud</th>
                <th>Estado</th>
                <th>Acciones</th>
            </thead>
            <tbody>
            <tr v-for="(solicitud, index) in solicitudes">
                <td>{{solicitud.trabajador.primer_nombre+' '+solicitud.trabajador.primer_apellido}}</td>
                <td>{{solicitud.asunto}}</td>
                <td>{{solicitud.tipo_solicitud}}</td>
                <td v-html="solicitud.comentario"></td>
                <td>{{solicitud.created_at | moment("DD/MM/YYYY")}}</td>
                <td>{{solicitud.estado}}</td>
                <td>
                    <a :href="'/solicitude-responder/'+solicitud.id" class="btn btn-success btn-sm" title="Ver Solicitudes"><i class="fa fa-arrow-right"></i></a>
                </td>
            </tr>
            </tbody>

        </table>


    </div>
</template>

<script>
export default {
    name:'solicitudes-index',
    data() {
        return {
            solicitudes: [],
            arraySolicitud:[],
            estado:'',
            arrayTipoSolicitud:[
                'copia de contrato',
                'certificado antiguidad',
                'carga familiar',
                'modificación de datos'
            ],
            tipo_solicitud:''
        }
    },
    mounted() {
        this.obtenerSolicitudes()
    },
    methods: {
       obtenerSolicitudes: function (){
           axios.get('/getSolicitudes').then((res)=>{
                this.solicitudes = res.data
                this.arraySolicitud = res.data
           }).catch((error)=>{
                console.log(error)
           })
       },
        cambiar_estado:function (){
            this.solicitudes = this.arraySolicitud.filter((item)=> item.estado === this.estado)
        },
        cambioTipoSolicitud:function (){
            this.solicitudes = this.arraySolicitud.filter((item)=> item.tipo_solicitud === this.tipo_solicitud)
        }
    },
}
</script>


