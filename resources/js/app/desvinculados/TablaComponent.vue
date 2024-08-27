<template>
    <div>

        <div class="btn-group mb-3">
            <button type="button" class="btn btn-success btn-sm" @click="filtrar=!filtrar"><i class="fa fa-filter"></i> Filtrar</button>

        </div>

        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
            <thead>
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th>RUT</th>
                    <th>NOMBRE</th>
                    <th>ESTADO</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">
                <tr v-show="filtrar">
                    <td colspan="2">
                        <select
                            name="trabajador_id"
                            class="form-select mb-2"
                            id="trabajador_id"
                            data-control="select2"
                            data-placeholder="Seleccione trabajador"
                            data-allow-clear="true">
                            <option value="">--------</option>
                            <option v-for="({TRABAJADOR_ID,NOMBRE_COMPLETO,RUT}, index) in trabajadores_list"  :value="TRABAJADOR_ID">{{RUT+' - '+ NOMBRE_COMPLETO}}</option>
                        </select>
                    </td>
                    <td></td>
                    <td></td>
                </tr>

                <tr v-for="({RUT,TRABAJADOR_ID,NOMBRE_COMPLETO,ESTADOS_TRABAJADOR}, index) in trabajadores.data">

                    <td>{{RUT}}</td>
                    <td>{{NOMBRE_COMPLETO }}</td>

                    <td><span class="badge badge-danger">{{ESTADOS_TRABAJADOR}}</span></td>
                    <td>

                        <div class='btn-group'>
                            <a :href="'/formulario-reincorpocacion/'+TRABAJADOR_ID" class="btn btn-primary btn-sm" title="reincorporar"><i class="fa fa-edit"></i></a>
                        </div>

                    </td>
                </tr>
            </tbody>
        </table>

        <div class="row">

            <div class="col-md-10">
                <nav aria-label="Page navigation example mt-3">
                    <ul class="pagination">
                        <li v-for="paginate in trabajadores.links" :class="paginate.active ? page_class: 'page-item'"><a class="page-link" href="#" rel="nofollow" @click="getPaginate(paginate.label)">{{paginate.label}}</a></li>
                    </ul>
                </nav>
            </div>
        </div>

    </div>
</template>

<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    components:{
        Loading
    },
    data() {
        return {
            ubicaciones: [],
            cargos:[],
            areas:[],
            empleadores:[],
            rut:'',
            cargos_id:[],
            empleador_id:'',
            ubicacion_id:'',
            fecha_ingreso_inicial:'',
            fecha_ingreso_final:'',
            trabajadores:[],
            filtrar:false,
            paginate:['trabajadores'],
            perpage:20,
            isLoading: false,
            fullPage: true,
            trabajadores_list:[],
            trabajador_id:0,
            page:0,
            page_class:'page-item active'
        }
    },
    mounted() {
        this.cargarTablaTrabajadores();
        this.cargarCargos()
        this.cargarEmpleador()
        this.getTrabajadores()

    },
    updated() {
        //this.refrescar()
        $('#trabajador_id').on('select2:select', this.onSelectTraabajador)
    },
    methods:{
        refrescar:function(){
            //this.$refs.categorias.selectpicker('refresh')
            $(this.$refs.trabajadores).selectpicker('refresh')
            // $(this.$refs.buses).selectpicker('refresh')
        },
        onSelectTraabajador:function(e){
            this.trabajador_id =parseInt(e.params.data.id);
            //transformalo en int
            //  this.trabajador_id = parseInt(this.trabajador_id)
            this.cargarTablaTrabajadores()
        },
        async getTrabajadores (){
            try{
                let url = '/lista-trabajadores-desvinculados?opciones=get'

                const {data , status} =  await axios.get(url)

                if(status === 200){
                    this.trabajadores_list = data
                }

            }catch(e){
                 console.log(e)
            }
        },
      async  cargarTablaTrabajadores (){
           try{
               this.isLoading = true;
               // simulate AJAX
               setTimeout(() => {
                   this.isLoading = false
               }, 5000)

               let url = '/lista-trabajadores-desvinculados?opciones=paginate'

               if (this.page > 0){
                   url = url + '&page='+this.page
               }

               if (this.trabajador_id >0){
                   url = url + '&rut='+this.trabajador_id
               }

               const {data , status} = await axios.get(url)

               if (status === 200){
                   this.trabajadores = data
               }
           }catch (e) {
               console.log(e)
           }
        },
       async mostrarFiltrar (){
            this.filtrar = !this.filtrar
        },
       async cargarCargos (){

           await axios.get('/cargos').then(res=>{
                this.cargos = res.data
            })
        },
       async cargarEmpleador(){
           await axios.get('/empleador').then(res=>{
                this.empleadores = res.data
            })
        },
        getPaginate:function (page_number){
            this.page =  page_number
            this.page_class = 'page-item active'
            this.cargarTablaTrabajadores()
        },
        cantidadRegistros:function (){
            this.page = 1
            this.cargarTablaTrabajadores()
        }

    }

}

</script>

<style scoped>
/* Las animaciones de entrada y salida pueden usar */
/* funciones de espera y duración diferentes.      */
.slide-fade-enter-active {
    transition: all .3s ease;
}
.slide-fade-leave-active {
    transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to
    /* .slide-fade-leave-active below version 2.1.8 */ {
    transform: translateX(10px);
    opacity: 0;
}

th{
    font-weight: bolder!important;
    color: #fff!important;
}
th a:hover{
    cursor: pointer;
    color: #222222!important;
}

thead tr th{
    background-color: #D3B560;
    color: white;
}
</style>

