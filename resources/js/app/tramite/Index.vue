<template>
<div>
    <CardComponent :title="'Licencia Medicas'">
        <template #header>
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-group mb-3">
                    <a href="/licencias-medicas/create" class="btn btn-primary btn-sm"> <i class="fa fa-plus-circle"></i> Agregar</a>
                    <button type="button" class="btn btn-secondary btn-sm" @click.prevent="openModalImportar"><i class="fa fa-upload"></i> Importar </button>
                    <button class="btn btn-success btn-sm" @click="filtrar = !filtrar"> <i class="fa fa-filter"></i> Filtrar</button>
                    <!--            <button type="button" class="btn btn-outline-success btn-sm mb-3" ><i class="fa fa-circle-arrow"></i> Comprobar Licencias </button>-->
                </div>
            </div>
            </div>

        </template>
        <template #body>
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                    <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th>ID</th>
                        <th>RUT</th>
                        <th>Nombre</th>
                        <th>Empleador</th>
                        <th>Fecha Emisión</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Días</th>
                        <th>Ingresado por</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                    <tr v-show="filtrar">
                        <td colspan="3">
                            <select name="trabajador_id" class="form-control selectpicker" v-model="trabajador_id_filtro" @change.prevent="getLicencias()"  ref="trabajadores" data-size="10" data-live-search="true" id="trabajador_id">

                                <option value="">--------</option>
                                <option v-for="({id, rut, primer_nombre, primer_apellido, segundo_apellido}, index) in trabajadores"  :value="id">{{rut+' - '+primer_nombre +' '+ primer_apellido+ ' ' +segundo_apellido}}</option>
                            </select>
                        </td>

                        <td>
                            <select name="empresas" id="empresas" @change.prevent="getLicencias()" v-model="empleador_id" class="form-control form-control-sm">
                                <option value="" selected>----Empresas----</option>
                                <option v-for="({id,nombre_empleador}, index) in empleadores" :value="id">{{nombre_empleador}}</option>
                            </select>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr v-for="({LICENCIA_ID,RUT,NOMBRE_COMPLETO,EMPLEADOR,FECHA_EMISION,FECHA_INICIO,FECHA_FIN,DIAS,INGRESADO_POR}, index) in licencias.data">
                        <td>{{LICENCIA_ID}}</td>
                        <td>{{RUT}}</td>
                        <td>{{NOMBRE_COMPLETO}}</td>
                        <td>{{EMPLEADOR}}</td>
                        <td>{{FECHA_EMISION | FormatoFecha}}</td>
                        <td>{{FECHA_INICIO | FormatoFecha}}</td>
                        <td>{{FECHA_FIN | FormatoFecha}}</td>
                        <td>{{DIAS}}</td>
                        <td>{{INGRESADO_POR}}</td>
                        <td>
                           <div class="btn-group">
                               <button @click.prevent="abrir_licencia_medica(LICENCIA_ID)" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                               <button @click.prevent="eliminar_licencia(LICENCIA_ID)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                           </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <nav aria-label="Page navigation example mt-3">
                    <ul class="pagination">
                        <li v-for="{active , label} in licencias.links" :class="active ? page_class: 'page-item'"><a class="page-link" href="#" rel="nofollow" @click="getPaginate(label)">{{label}}</a></li>
                    </ul>
                </nav>
            </div>
        </template>
    </CardComponent>


    <!-- VER LICENCIA MEDICA -->
    <div class="modal fade" id="LicenciaMedicaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detalle de licencia Medica</h5> <button class="btn btn-danger" @click.prevent="editar_licencia()">Editar</button>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="nombre">RUT</label>
                            <input type="text" v-model="rut" id="rut" class="form-control" :disabled="true">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" v-model="nombre_trabajador" id="nombre" class="form-control" :disabled="true">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="cargo">Cargo</label>
                            <input type="text" v-model="cargo_trabajador" id="cargo" class="form-control" :disabled="true">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="ubicacion">Ubicación</label>
                            <input type="text" v-model="ubicacion_trabajador" id="ubicacion" class="form-control" :disabled="true">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="empleador">Empleador</label>
                            <input type="text" v-model="nombre_empleador" id="empleador" class="form-control" :disabled="true">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="fecha_emision">Fecha Emisión</label>
                            <input type="date" v-model="fecha_emision" :disabled="editar" id="fecha_emision" class="form-control" >
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="fecha_recepcion">Fecha Recepción</label>
                            <input type="date" v-model="fecha_recepcion" :disabled="editar"   id="fecha_recepcion" class="form-control" >
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="fecha_procesado">Fecha Procesado</label>
                            <input type="date" v-model="fecha_procesado" :disabled="editar" id="fecha_procesado" class="form-control" >
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="fecha_inicio">Fecha Inicio</label>
                            <input type="date" v-model="fecha_inicio" :disabled="editar" id="fecha_inicio" class="form-control" >
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="dias">Días</label>
                            <input type="number" v-model="dias" :disabled="editar" id="dias"  class="form-control" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Tipo de licencia medica</label>
                            <input name="" v-model="tipo_licencia" class="form-control" :disabled="editar">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="medio">Medio</label>
                            <input  v-model="medio" id="medio" class="form-control" :disabled="editar">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="motivo">Motivo</label>
                            <input type="text" v-model="motivo" :disabled="editar" id="motivo" class="form-control" >
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button :disabled="editar" @click.prevent="enviarFormulario()" class="btn btn-success">Guardar</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>
    <!-- IMPORTAR LICENCIA MEDICAS -->
    <div class="modal  fade" id="importarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Importar Licencias Medicas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-warning">
                                <i class="fa fa-download"></i>  Descargar Formado de importación <a href="/upload/licencias/licencias_formato.xlsx">Aqui</a>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <input  name="excel" ref="file"  id="file-upload" class="form-control-file" type="file" aria-label="Adjunte su Reporte Anual" @change="onFileChange()" required   accept=".xlsx, .xls, .csv" />
                        </div>
                        <p v-if="message">{{ message }}</p>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                    <button type="button"  class="btn btn-primary btn-sm" @click.prevent="cargaDatos()">Guardar</button>

                </div>
            </div>
        </div>
    </div>

</div>

</template>

<script>


import CardComponent from "../../components/CardComponent.vue";
export default {
    components: {CardComponent},
    component:{
        CardComponent
    },
    data() {
        return {
            id_licencia:0,
            tipo_licencia:0,
            fecha_emision:'' ,
            fecha_inicio:'',
            fecha_recepcion:'',
            fecha_procesado:'',
            fecha_fin:'',
            medio:'',
            licencias:[],
            trabajador_id:0,
            nombre_trabajador:'',
            cargo_trabajador:'',
            nombre_empleador:'',
            ubicacion_trabajador:'',
            trabajador_id_filtro:0,
            trabajadores:[],
            rut:'',
            dias:0,
            motivo:'',
            filtrar:false,
            medios:['mutualidad', 'imed', 'medipass' ,'física'],
            tipo_licencias:[
                {
                    value:1,
                    descripcion:'ENFERMEDAD O ACCIDENTE COMÚN'
                },
                {
                    value:2,
                    descripcion:'PRORROGA MEDICINA PREVENTIVA'
                },
                {
                    value:3,
                    descripcion:'LICENCIA MATERNAL PRE Y POST NATAL'
                },
                {
                    value:4,
                    descripcion:'ENFERMEDAD GRAVE NIÑO MENOR DE 1 AÑO'
                },
                {
                    value:5,
                    descripcion:'ACCIDENTE DEL TRABAJO O DEL TRAYECTO'
                },
                {
                    value:6,
                    descripcion:'ENFERMEDAD PROFESIONAL'
                },
                {
                    value:7,
                    descripcion:'PATOLOGIA DEL EMBARAZO'
                },

            ],
            editar:true,
            page:0,
            page_class:'page-item active',
            empleador_id:0,
            empleadores:[],
            size:'',
            filename:'',
            archivo:'',
            message:'',
        }
    },
    mounted() {
      this.getLicencias()
      this.getTrabajadores()
      this.cargarEmpleador()
    },
    updated() {
        this.refrescar()
    },
    methods: {
        refrescar:function(){
            //this.$refs.categorias.selectpicker('refresh')
            $(this.$refs.trabajadores).selectpicker('refresh')
            // $(this.$refs.buses).selectpicker('refresh')
        },
        async getTrabajadores (){
            try {

                const {data , status} = await axios.get('/lista-trabajadores')

                if (status === 200){
                    this.trabajadores = data
                }

            }catch (error) {
                console.log(error)
            }

        },
      async getLicencias(){
            try {
                let url = '/getLicencias?opciones=1'

                if (this.trabajador_id_filtro > 0){
                    url = url + '&trabajador_id='+this.trabajador_id_filtro
                }

                if (this.empleador_id > 0){
                    url = url + '&empleador_id='+this.empleador_id
                }

                if (this.page > 0){
                    url = url + '&page='+this.page
                }

              const {data ,status} = await axios.get(url)
                if (status == 200){
                    this.licencias = data
                }

            }catch (error){
                console.log(error)
            }
       },
       async cargarEmpleador(){
            try{
                const { data, status} = await axios.get('/empleador')
                if (status == 200){
                    this.empleadores = data
                }
            }catch (error){
                console.log(error)
            }
        },
        abrir_licencia_medica:function (id){
            const { data } = this.licencias
            let licencias = data.find((item) => item.LICENCIA_ID === id)
            console.log(licencias)
            //ASIGNAR VALORES A VARIABLES
            const { LICENCIA_ID,
                    TIPO_LICENCIA,
                    NOMBRE_LICENCIA,
                    FECHA_EMISION,
                    FECHA_INICIO,
                    FECHA_PROCESADO,
                    FECHA_RECEPCION,
                    FECHA_FIN,
                    DIAS,
                    RUT,
                    TRABAJADOR_ID,
                    NOMBRE_COMPLETO,
                    MOTIVO,
                    MEDIO,
                    EMPLEADOR,
                    CARGO,
                    UBICACION
            } = licencias

            //ASIGNA VALORES A LOS CAMPOS
            this.id_licencia = LICENCIA_ID
            this.tipo_licencia = NOMBRE_LICENCIA
            this.fecha_emision = FECHA_EMISION
            this.fecha_inicio = FECHA_INICIO
            this.fecha_procesado = FECHA_PROCESADO
            this.fecha_recepcion = FECHA_RECEPCION
            this.fecha_fin = FECHA_FIN
            this.dias = DIAS
            this.rut = RUT
            this.trabajador_id = TRABAJADOR_ID
            this.nombre_trabajador = NOMBRE_COMPLETO
            this.motivo = MOTIVO ?? 'Sin motivo ingresado'
            this.medio = MEDIO
            this.nombre_empleador = EMPLEADOR
            this.cargo_trabajador = CARGO
            this.ubicacion_trabajador = UBICACION


           $('#LicenciaMedicaModal').modal('show')

        },
        editar_licencia:function (){
           if( this.editar == true)
           {
               this.editar = false
           }else {
               this.editar = true
           }
        },
        async enviarFormulario(){
            try{

                let formData = new FormData

                formData.append('fecha_emision',this.fecha_emision)
                formData.append('fecha_inicio',this.fecha_inicio)
                formData.append('fecha_termino',this.fecha_fin)
                formData.append('fecha_recepcion',this.fecha_recepcion)
                formData.append('fecha_procesado',this.fecha_procesado)
                formData.append('medio',this.medio)
                formData.append('dias',this.dias)
                formData.append('motivo',this.motivo)
                formData.append('trabajador_id',this.trabajador_id)
                formData.append('tipo_licencia',this.tipo_licencia)

                const { status } =   await axios.post('/licencias-medicas/'+this.id_licencia,formData)

                if (status == 200){
                    this.respuesta = true
                    this.alerta = 'alert-success'
                    this.$swal('Licencia medica agregada exitosamente')
                    window.location.href = "/licencias-medicas";
                }

            }catch (error){
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al enviar el formulario'
                this.errorsClass = 'form-control is-invalid';


                this.$swal('error al enviar el formulario')
            }

        },
        async cargaDatos(){
            try{
                let formData =  new FormData()

                if(this.archivo !== ''){
                    formData.append('file',this.archivo)
                }else{
                    this.$swal('Debe cargar un archivo excel')
                    return
                }
                this.$Progress.start();
             const { data , status } =   await axios.post('/carga-archivos-licencias',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })

                if(status === 200){
                    //console.log(data)
                    this.message = `Registros exitosos: ${data.registros_exitosos}, Registros fallidos: ${response.data.registros_fallidos}`;
                    this.$Progress.finish();
                    this.$swal.fire({
                        title: 'Carga de datos',
                        text: 'Datos cargados correctamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    })
                    this.getLicencias()
                    $('#importarModal').modal('hide')
                }

            }catch (error) {
                this.message = 'Error al importar el archivo';
                this.$Progress.fail();

                this.$swal.fire({
                    title: 'Carga de datos',
                    text: 'Error al cargar los datos',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                })
            }

        },
        calcular_fecha_termino(){
            let fecha_inicio
            let dias
            let fecha_final

            /*VALIDAR FECHA DE INICIO*/
            if (this.fecha_inicio !== ''){
                fecha_inicio = new Date(this.fecha_inicio)
                console.log(fecha_inicio)
            }else{
                this.$swal('debe ingresar fecha de inicio')
            }

            /*VALIDAR FECHA DE INICIO*/
            if (this.dias !== 0){
                dias = parseInt(this.dias)
            }else{
                this.$swal('debe ingresar dias')
            }
            //SUMA DE FECGA DE INICIO + DIAS

            fecha_inicio.setDate(fecha_inicio.getDate() + dias);
            //console.log(fecha_inicio.getDate())
            //ASIGNAR VALOR OBTENIDO A LA VARIABLE FECHA FINAL
            this.fecha_fin = fecha_inicio.getFullYear() + '-' +
                (fecha_inicio.getMonth() + 1) + '-' + fecha_inicio.getDate();
        },
        async eliminar_licencia(id){
            try {

                this.$swal({
                    title: '¿Estas seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Si, bórralo!'
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        const {status} = await axios.delete('/licencias-medicas/' + id)
                            .then((response) => {
                                this.$swal(
                                    '¡Eliminado!',
                                    'El registro ha sido eliminado.',
                                    'success'
                                ).then(() => {
                                    this.getLicencias()
                                })
                            })
                            .catch((error) => {
                                console.log(error);
                            })
                    }
                })

            }catch (error) {
                this.$swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Algo salio mal!',
                })
            }
        },
        getPaginate(page_number){
            this.page =  page_number
            this.page_class = 'page-item active'
            this.getLicencias()
        },
        openModalImportar(){
            $('#importarModal').modal('show')
        },
        onFileChange() {
            //console.log(e.target.files[0]);
            this.filename =   this.$refs.file.files[0].name;
            this.size =  this.file = this.$refs.file.files[0].size;
            this.archivo = this.$refs.file.files[0];
        },
    },
}
</script>

<style scoped>
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
