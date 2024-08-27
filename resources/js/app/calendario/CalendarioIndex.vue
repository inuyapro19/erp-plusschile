<template>
    <div class="col-lg-11 mx-auto">
        <button type="button" class="btn btn-success btn-sm" @click="openModalCreate"><i class="fa fa-plus"></i> Agregar</button>
        <div class="row mt-3">
            <div class="col-md-12">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th>ID</th>
                            <th>Año</th>
                            <th>Mes</th>
                            <th>Día</th>
                            <th>Tipo de Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                    <tr v-for="(calendario, index) in calendarios">
                        <td>{{calendario.id}}</td>
                        <td>{{calendario.anyo}}</td>
                        <td>{{calendario.mes}}</td>
                        <td>{{calendario.dia}}</td>
                        <td>{{calendario.tipo_de_fecha}}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger" @click="openModalEliminar(calendario.id)"  title="Eliminar"><i class="fa fa-trash"></i></button>
                            <button type="button" class="btn btn-sm btn-info"  @click="openModalEditar(calendario.id)"   title="Editar"><i class="fa fa-edit"></i></button>
                        </td>
                    </tr>
                    </tbody>
                </table>


            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="CalendarioModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Calendario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
                            </div>
                            <div class="col-md-6">

                                <label for="anyo">AÑO</label>
                                <input type="text" v-model="anyo" id="anyo" class="form-control">
                            </div>
                            <div class="col-md-6">

                                <label for="mes">MES</label>
                                <select v-model="mes" id="mes" class="form-control">
                                    <option value="">--------</option>
                                    <option v-for="mes in meses" :value="mes">{{mes}}</option>
                                </select>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">

                                <label for="dia">Dia</label>
                                <input type="text" v-model="dia" id="dia" class="form-control">
                            </div>
                            <div class="col-md-6">

                                <label for="mes">Tipo de Fecha</label>
                                <select v-model="tipo_de_fecha" id="mes"  @change.prevent="esFeriado" class="form-control">
                                    <option value="">--------</option>
                                    <option value="feriado">Feriado</option>
                                    <option value="fin de semana">Fin de semana</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" v-show="isFeriado">
                            <div class="col-md-6">
                                <label for="mes">Tipo de feriado</label>
                                <select v-model="tipo_feriado" id="mes" @change="esRegional()" class="form-control">
                                    <option value="">--------</option>
                                    <option v-for="tipo in tipos_feriados" :value="tipo">{{ tipo.toUpperCase()}}</option>

                                </select>
                            </div>
                        </div>
                        <div class="row" v-show="isRegional">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="region">Región</label>
                                <select  class="form-control" id="region">
                                    <option value="">-----------------</option>
                                    <option v-for="(region, index) in regiones" :value="region.id">{{region.nombre_region}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="button" v-show="crear" class="btn btn-primary btn-sm" @click.prevent="agregarCalendario()">Guardar</button>
                        <button type="button" v-show="editar" class="btn btn-primary btn-sm" @click.prevent="CalendarioEditar(id)">Editar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="CalendarioEleminarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eliminarModalLabel">Eliminar Calendario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
                                <p>¿Desea Eliminar Calendario?</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary btn-sm" @click.prevent="eliminarCalendario(id)">Eliminar</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>


export default {

    data() {
        return {
            anyo:'',
            meses:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
            mes:'',
            dia:'',
            fecha_inicio:'',
            fecha_termino:'',
            tipo_de_fecha:'',
            calendarios:[],
            editar:false,
            crear:false,
            id:0,
            tipo_feriado:'',
            tipos_feriados:['nacional','regional'],
            isFeriado:false,
            isRegional:false,
            regiones:[],
            region: 0
        }
    },
    mounted() {
        this.getCalendario()
        this.cargarState()
    },
    methods: {
       async getCalendario(){
           axios.get('/getCalendario').then((res)=>{
                this.calendarios = res.data
           }).catch((error)=>{
               console.log(error)
           })
       },
        cargarState:function(){
            axios.get('/regiones').then(res=>{
                this.regiones = res.data
            })
        },
        openModalCreate:function (){
            var today = new Date();
            var year = today.getFullYear();

            this.editar = false
            this.crear = true
            this.anyo = year
            this.mes = ''
            this.dia = 0
            this.fecha_inicio = ''
            this.fecha_termino = ''
            this.tipo_de_fecha = ''
            this.tipo_feriado = ''

            $('#CalendarioModal').modal('show')
        },
        openModalEditar:function(id){
            this.crear = false
            this.editar = true
            this.id = id
            let calendario = this.calendarios.find((item) => item.id === this.id);
            this.anyo = calendario.anyo
            this.mes = calendario.mes
            this.dia = calendario.dia
            this.fecha_inicio = calendario.fecha_inicio
            this.fecha_termino = calendario.fecha_termino
            this.tipo_de_fecha = calendario.tipo_de_fecha
            this.tipo_feriado = calendario.tipo_de_feriado
            $('#CalendarioModal').modal('show')
        },
        async agregarCalendario(){
            await axios.post('/calendarios-configuracion',{anyo:this.anyo,mes:this.mes,dia:this.dia,fecha_inicio:this.fecha_inicio,fecha_termino:this.fecha_termino,tipo_de_fecha:this.tipo_de_fecha,tipo_de_feriado: this.tipo_feriado,region_id:this.region_id}).then((res)=>{
                this.respuesta = true
                this.alerta= 'alert-success'
                this.mensajes = 'Calendario Creado exitosamente'
                this.getCalendario()
                this.nombre_cliente = '';
                $('#CalendarioModal').modal('hide')

            }).catch((error)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al enviar el formulario'
                this.errorsClass = 'form-control is-invalid';

            })
        },
        openModalEliminar:function(id){
            this.id = id
            //console.log(this.id)
            $('#CalendarioEleminarModal').modal('show')
        },
        async eliminarCalendario(id){
           axios.delete('/calendario-configuracion/'+id).then((res)=>{
               this.getCalendario()
               this.$swal('Fecha Eliminada Correctamente')
           }).catch((error)=>{
               this.$swal('Error al eliminar fecha')
               console.log(error)
           })
        },
       async CalendarioEditar(id){
           await axios.post('/calendarios-configuracion/'+id,{anyo:this.anyo,mes:this.mes,dia:this.dia,fecha_inicio:this.fecha_inicio,fecha_termino:this.fecha_termino,tipo_de_fecha:this.tipo_de_fecha,tipo_de_feriado: this.tipo_feriado,region_id:this.region_id}).then((res)=>{
               this.respuesta = true
               this.alerta= 'alert-success'
               this.mensajes = ' Creado exitosamente'
               this.getCalendario()
               this.nombre_cliente = '';
               $('#CalendarioModal').modal('hide')

           }).catch((error)=>{
               this.respuesta = true
               this.alerta= 'alert-danger'
               this.mensajes = 'Error al enviar el formulario'
               this.errorsClass = 'form-control is-invalid';

           })
       },
        esFeriado:function (){
           if (this.tipo_de_fecha === 'feriado'){

               this.isFeriado = true
           }else{

              this.isFeriado = false
           }
        },
        esRegional:function (){
            if (this.tipo_feriado === 'regional'){
                this.isRegional = true
            }else{
                this.isRegional = false
            }
        }
    },
}
</script>

<style scoped>

</style>
