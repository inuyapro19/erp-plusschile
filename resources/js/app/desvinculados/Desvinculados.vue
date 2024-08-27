<template>
    <CardComponent title="Trabajadores Desvinculados">
        <template #header>
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-group mb-3">
<!--                        <button href="/export-trabajadores" @click="handleExport"
                                class="btn btn-secondary btn-sm"><i class="fa fa-cloud-download-alt"></i> Descargar</button>-->
                        <button type="button" class="btn btn-success btn-sm" @click="mostrarFiltrar"><i
                            class="fa fa-filter"></i> Filtrar
                        </button>
                    </div>
                </div>
            </div>
        </template>
        <template #body>
            <DataTable
                :columns="columns"
                :items="trabajadores.data"
                :isCheck="false"
                :colores="colores"
            >
                <template #acciones="{ item }">
                    <div class="btn-group">

                    </div>
                </template>
            </DataTable>
        </template>

    </CardComponent>
</template>

<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import CardComponent from "../../components/CardComponent.vue";
import DataTable from "@/components/DataTable.vue";
export default {
    components:{
        CardComponent,
        DataTable,
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
            page_class:'page-item active',
            columns: [
                {
                    id: 1,
                    label: 'ID',
                    key: 'TRABAJADOR_ID'
                },
                {
                    id: 2,
                    label: 'Codigo',
                    key: 'CODIGO_TRABAJADOR',
                    isVisible: true
                },
                {
                    id: 3,
                    label: 'Rut',
                    key: 'RUT',
                    isVisible: true
                },
                {
                    id: 4,
                    label: 'Nombre',
                    key: 'NOMBRE_COMPLETO',
                    isVisible: true
                },
                {
                    id: 5,
                    label: 'Fecha Desvinculacion',
                    key: 'FECHA_DESVINCULACION',
                    isVisible: true
                },
                {
                    id: 6,
                    label: 'Motivo Desvinculacion',
                    key: 'MOTIVO_DESVINCULACION',
                    isVisible: true
                },
                {key: 'ESTADO_TRABAJADOR', label: 'Estado', badge: true},
            ],
            colores:[
                {status: 'disponible', label: '', color: 'success'},
                {status: 'dias libre', label: '', color: 'info'},
                {status: 'vacaciones', label: '', color: 'warning'},
                {status: 'falla', label: '', color: 'danger'},
                {status: 'en ruta', label: '', color: 'primary'},
                {status: 'licencia médica', label: '', color: 'secondary'},
                {status: 'permiso especial', label: '', color: 'dark'},
                {status: 'contratado', label: 'Contratado', color: 'light-success'},
                {status: 'desvinculado', label: 'Desvinculado', color: 'light-danger'},
            ]
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

               let url = '/getTrabajadoresDevinculados'

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
        },
       async handleExport(){
            try {
                const response = await axios({
                    url: '/export-trabajadores-desvinculados',
                    method: 'GET',
                    responseType: 'blob', // Important
                });
                //console.log(response.data)
                let date = Date.now()
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;

                link.setAttribute('download', date+'.xlsx'); //or any other extension
                document.body.appendChild(link);
                link.click();
            } catch (error) {
                console.error("Error downloading the file.");
            }
        },

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

