<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                 <button class="btn btn-success btn-sm" @click.prevent="generarLiquidaciones()">Generar todos</button>
                 <button class="btn btn-danger btn-sm" @click.prevent="openModalEliminar()">Eliminar</button>
                 <!--<button class="btn btn-info btn-sm" @click.prevent="openModalImprimir()">Imprimir</button>--->
            </div>
        </div>
        <div v-show="active_circle_bar" style="width:400px;max-width:400px;height:400px;background-color:rgba(255,255,255,0.5);z-index: 9999;position: absolute;top: 0;left: 0;bottom:0;right: 0;margin:auto;padding: auto">
            <vue-ellipse-progress

                :progress="progress"
                color="#D7C26D"
                animation="rs 700 200"
                :loading="false"
            />
        </div>
        <div class="row mt-3">
            <div class="col-md-3">
                <select v-model="mes" @change="getLiquidacionMensual()" class="form-control">
                    <option value="0" >----Meses-----</option>
                    <option v-for="(mes, index) in meses" :value="index+1">{{ mes }}</option>
                </select>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th><input type="checkbox" v-model="seleccionarTodos" @change="selectALL"></th>
                            <th>#</th>
                            <th>RUT</th>
                            <th>NOMBRE</th>
                            <th>CARGO</th>
                            <th>EMPLEADOR</th>
                            <th>MES</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        <tr v-if="trabajadores_mes_liquidacion.data.length === 0" class="text-center">
                            <td colspan="8"> <span class="text-center">Aun no hay registro para mostrar</span></td>
                        </tr>

                        <tr v-else  v-for="(liquidacion, index) in trabajadores_mes_liquidacion.data">
                            <td><input type="checkbox" :value="liquidacion.LIQUIDACION_ID" v-model="seleccion_masiva_id"></td>
                            <td>{{liquidacion.TRABAJADOR_ID}}</td>
                            <td>{{liquidacion.RUT}}</td>
                            <td>{{liquidacion.NOMBRE_COMPLETO}}</td>
                            <td>{{liquidacion.CARGO}}</td>
                            <td>{{liquidacion.NOMBRE_EMPLEADOR}}</td>
                            <td>{{liquidacion.MES}}/{{liquidacion.YEAR}}</td>
                            <td><button class="btn btn-secondary btn-sm" @click="openModalImprimirSingle(liquidacion.LIQUIDACION_ID)"><i class="fa fa-print"></i></button></td>
                        </tr>

                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-1">{{trabajadores_mes_liquidacion.length}}
                        <select v-model="per_page" class="form-control form-control-sm" @change.prevent="cantidadRegistros">
                            <option v-for="numero in numero_registros" :value="numero">{{numero}}</option>
                        </select>
                    </div>
                    <div class="col-md-11">
                        <nav aria-label="Page navigation example mt-3">
                            <ul class="pagination">
                                <li v-for="paginate in trabajadores_mes_liquidacion.links" :class="paginate.active ? page_class: 'page-item'"><a class="page-link" href="#" rel="nofollow" @click="getPaginate(paginate.label)">{{paginate.label}}</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

            </div>
        </div>
        <!-- eliminacion masiva -->
        <div class="modal  fade" id="eliminarMasivaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Eliminacion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                Desea Eliminar estos Registros
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="button" v-if="seleccion_masiva_id.length > 0" class="btn btn-danger btn-sm" @click.prevent="eliminarMasiva()">Eliminar</button>

                    </div>
                </div>
            </div>
        </div>

        <!-- imprimir liquidaciones masiva -->
        <div class="modal  fade" id="ImprimirModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Imprimir</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding: 0!important;">
                        <iframe src="/upload/liquidaciones/liquidacion.pdf" width="100%" height="800"></iframe>
                    </div>

                </div>
            </div>
        </div>
        <!-- imprimir liquidaciones single -->
        <div class="modal  fade" id="ImprimirSingleModal" ref="imprimirPdfSingle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Imprimir</h5>
                        <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding: 0!important;">
                        <iframe :src="url_pdf" width="100%" height="800"></iframe>
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
          mes:0,
            meses:[
                'ENERO',
                'FEBRERO',
                'MARZO',
                'ABRIL',
                'MAYO',
                'JUNIO',
                'JULIO',
                'AGOSTO',
                'SEPTIEMBRE',
                'OCTUBRE',
                'NOVIEMBRE',
                'DICIEMBRE'
            ],
            cargos:[],
            cargo_id:0,
            empleadores:[],
            empleador_id:0,
            trabajadores:[],
            trabajador_id:0,
            trabajadores_mes_liquidacion:[],//contiene las liquidaciones creadas del mes actual
            estado:'activo',
            estado_filtro:'',
            page:0,
            page_class:'page-item active',
            seleccion_masiva_id:[],
            seleccionarTodos:false,
            numero_registros:[10,20,50,80,100,500,1000],
            per_page:10,
            url_pdf:'/upload/liquidaciones/',
            liquidaciones_all:[],
            progress:0,
            active_circle_bar:false
        }

    },
    mounted() {
        this.getMesActual()
        this.getTrabajadores();
        this.getLiquidacionMensual();
        this.cargarCargos();
        this.todosLiquidaciones()
       // $(this.$refs.imprimirPdfSingle).on("hidden.bs.modal", this.closeImprimirSingleModal)

    },

    updated() {

    },
    methods:{
        refrescar:function(){
            //this.$refs.categorias.selectpicker('refresh')
            $(this.$refs.trabajadores).selectpicker('refresh')
            $(this.$refs.trabajadores2).selectpicker('refresh')
            // $(this.$refs.buses).selectpicker('refresh')
        },
        async getTrabajadores (){
            await axios.get('/lista-trabajadores').then((res)=>{
                this.trabajadores = res.data
            }).catch((error)=>{
                console.log(error)
            })
        },
        cargarCargos:function (){

            axios.get('/cargos').then(res=>{
                this.cargos = res.data
            })
        },
        getMesActual:function (){
            let fecha = new Date();
            let month = fecha.getMonth() + 1;
           // console.log(month)
            this.mes = month
        },
        async getLiquidacionMensual(){
            let url = '/getLiquidacion-mensual/'+this.mes+'?opciones=1&perpage='+this.per_page

            if (this.page > 0){
                url = url + '&page='+this.page
            }

            await axios.get(url).then((res)=>{
                this.trabajadores_mes_liquidacion = res.data
            }).catch((error)=>{
                console.log(error)
            })
        },
        getPaginate:function (page_number){
            this.page =  page_number
            this.page_class = 'page-item active'
            this.getLiquidacionMensual()
        },
        selectALL(){
            if(this.seleccionarTodos){
                this.trabajadores_mes_liquidacion.data.map((item)=>{
                    console.log(item.LIQUIDACION_ID)
                    this.seleccion_masiva_id.push(item.LIQUIDACION_ID)
                    console.table(this.seleccion_masiva_id)
                })
            }else{
                this.seleccion_masiva_id = []
                console.log(this.seleccion_masiva_id);
            }

        },
         generarLiquidaciones(){
             let cantidad = this.trabajadores.length
             this.active_circle_bar = true
           this.trabajadores.forEach((item, index)=>{
              /* axios.get('/mi-liquidacion-mensual/'+item.id+'?mes='+this.mes+'&filtro[rut]='+item.rut).then((res)=>{
                   console.log(res.data);

               }).catch(error =>{
                   console.log(error)
               });*/

               let progreso = index+1
               console.log(index+1)
               setTimeout(() => {
                   //display(name);
                  axios.get('/mi-liquidacion-mensual/'+item.id+'?mes='+this.mes+'&filtro[rut]='+item.rut).then((res)=>{
                       console.log(res.data);

                   }).catch(error =>{
                       console.log(error)
                   });
                   this.progress = (progreso/cantidad)*100
               }, index * 1000);
            })
             this.getLiquidacionMensual()
             //this.active_circle_bar = false
        },
        cantidadRegistros:function (){
            this.page = 1
            this.getLiquidacionMensual()
        },
        openModalEliminar:function (){
            $('#eliminarMasivaModal').modal('show')
        },
        async eliminarMasiva(){

            let datos = this.seleccion_masiva_id

            await axios.post('/eliminar-masiva-liquidacion', {datos:datos}).then((res)=>{
                this.$swal('Datos eliminados exitosamente')
                this.getLiquidacionMensual()
                $('#eliminarMasivaModal').modal('hide')
                this.seleccion_masiva_id = []
                this.seleccionarTodos = false
            }).catch((error)=>{
                console.log('error')
            })
        },
        openModalImprimir:function (){
           this.generarPdfMasivo()
            $('#ImprimirModal').modal('show')

        },
        openModalImprimirSingle:function (id){
            //console.log(id)
          let trabajador_mes_liquidacion =  this.trabajadores_mes_liquidacion.data.find((item) => item.LIQUIDACION_ID == id )
           // console.log(JSON.parse(trabajador_mes_liquidacion.RESUMEN_DETALLE))

          let liquidacion_documento =  JSON.parse(trabajador_mes_liquidacion.RESUMEN_DETALLE)

            axios.post('liquidacion-mensual-pdf',liquidacion_documento).then((res)=>{
                this.url_pdf = ''
                this.url_pdf = '/upload/liquidaciones/'+res.data
            }).catch(error =>{
                console.log(error)
            })
            $('#ImprimirSingleModal').modal('show')
        },
        todosLiquidaciones(){
            axios.get('getliquidacion-mensual-pdf-all?mes='+this.mes).then((res)=>{
                this.liquidaciones_all = res.data
            }).catch(error =>{
                console.log(error)
            })
        },
        generarPdfMasivo(){
          //  let liquidacion_documento =  JSON.parse(trabajador_mes_liquidacion.RESUMEN_DETALLE)
            let liquidaciones = []

            this.liquidaciones_all.forEach(item =>{
                liquidaciones.push(JSON.parse(item.RESUMEN_DETALLE))
            });

            console.log(liquidaciones)

            axios.post('liquidacion-mensual-pdf-all',liquidaciones).then((res)=>{
                this.liquidaciones_all = res.data
            }).catch(error =>{
                console.log(error)
            })
        }

    }
}
</script>

<style scoped>

</style>
