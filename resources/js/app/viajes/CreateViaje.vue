<template>
    <CardComponent
        :is-footer="false"
        :is-header="false"
    >
        <template #body>
            <form  @submit.prevent="enviarFormulario">
                <div class="row">
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label class="fs-6 fw-semibold mb-2" for="numero_bus">Asignar Bus (nro bus + pantente)</label>
                            <select-2
                                @select-changed="filtrar_por_empleador()"
                                :dataType="'number'"
                                v-model="bus_id"
                            >
                                <option  v-for="(bus, index) in buses"
                                         :value="bus.id">
                                    {{bus.numero_bus + ' - '+ bus.patente }}
                                </option>
                            </select-2>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label class="fs-6 fw-semibold mb-2" for="tipo_servicio">Tipo de viaje</label>
                            <select class="form-control form-control-solid" v-model="tipo_viaje" @change="es_servicio_mineria" id="tipo_servicio">
                                <option value="">-----Tipo de viaje-----</option>
                                <option value="servicio en linea">Servicio de linea</option>
                                <option value="servicio en mineria">Servicio de mineria</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4" v-show="tiene_cliente">
                        <div class="form-group">
                            <label class="fs-6 fw-semibold mb-2" for="tipo_servicio">Cliente</label>
                            <select class="form-control form-control-solid" v-model="cliente_id" id="cliente_id">
                                <option value="">-----Cliente-----</option>
                                <option v-for="(cliente, index) in clientes" :value="cliente.id">{{cliente.nombre_cliente}}</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label class="fs-6 fw-semibold mb-2" for="">Nro de viaje</label>
                            <input type="text" v-model="nro_viaje" name="nro_viaje" id="nro_viaje" class="form-control form-control-solid">
                            <small class="form-text text-muted">*NUMERO DE VIAJE PARA SERVICIO EN MINERIA ES SOLO PARA CONTROL INTERNO </small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label class="fs-6 fw-semibold mb-2" for="empresa_id">Empresa</label>
                            <select class="form-control form-control-solid" v-model="empleador_id" :disabled="true"  id="empresa_id">
                                <option value="">-----Empresas-----</option>
                                <option v-for="(empresa, index) in empleador" :value="empresa.id">{{empresa.nombre_empleador}}</option>
                            </select>
                        </div>
                    </div>


                </div>



                <div class="row">
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label  class="fs-6 fw-semibold mb-2" for="origen_id">Origen</label>
                            <select name="origen_id" class="form-control form-control-solid" v-model="origen_id" id="origen_id">
                                <option value="">----------</option>
                                <option v-for="(destino, index) in destinos" :value="destino.id">{{destino.ciudad}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label  class="fs-6 fw-semibold mb-2"  for="destino_id">Destino</label>
                            <select name="destino_id" class="form-control form-control-solid" @change="getMontoDestino()" v-model="destino_id" id="destino_id">
                                <option value="">----------</option>
                                <option v-for="(destino, index) in destinos" :value="destino.id">{{destino.ciudad}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label  class="fs-6 fw-semibold mb-2" for="destino_id">Tramo</label>
                            <select name="destino_id"
                                    class="form-control form-control-solid"
                                    @change.prevent="cargarRutas()"
                                    v-model="tramo" id="destino_id">
                                <option value="">----------</option>
                                <option
                                    v-for="(tramo, index) in tramos"
                                    :value="tramo.id">
                                    {{tramo.tramo}}
                                </option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label  class="fs-6 fw-semibold mb-2" for="">Fecha viaje</label>
                            <input
                                type="date"
                                v-model="fecha_viaje"
                                name="fecha_viaje"
                                id="fecha_viaje"
                                class="form-control form-control-solid"
                            >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label class="fs-6 fw-semibold mb-2" for="">Hora viaje - salida</label>
                            <input type="time"
                                   v-model="hora_viaje"
                                   @change.prevent="determina_hora_llegada()"
                                   name="hora_viaje"
                                   id="hora_viaje"
                                   class="form-control form-control-solid"
                            >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label
                                class="fs-6 fw-semibold mb-2"
                                for="">Fecha viaje - llegada</label>
                            <input
                                type="date"
                                v-model="fecha_llegada"
                                name="fecha_llegada"
                                :disabled="true"
                                id="fecha_llegada"
                                class="form-control form-control-solid"
                            >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label
                                class="fs-6 fw-semibold mb-2"
                                for="">Hora viaje - llegada
                            </label>
                            <input
                                type="time"
                                v-model="hora_viaje_llegada"
                                :disabled="true"
                                name="hora_viaje"
                                id="hora_viaje"
                                class="form-control form-control-solid"
                            >
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <label
                            class="fs-6 fw-semibold mb-2"
                            for="">
                            Destino especial
                        </label>
                    </div>
                    <!--<div class="col-md-4">
                        <label class="switch s-icons s-outline s-outline-success  mr-2">
                            <input type="checkbox" id="destino_especial" v-model="destino_especial" @change="aparecer_destino_especial()"  checked>
                            <span class="slider"></span>
                        </label>
                    </div>-->
                    <div class="form-check form-switch form-check-custom form-check-solid">
                        <input class="form-check-input"
                               type="checkbox"
                               id="destino_especial"
                               v-model="destino_especial"
                               @change="aparecer_destino_especial()"
                               checked
                        />
                        <label class="form-check-label fw-semibold text-gray-400 ms-3" for="status"></label>
                    </div>

                </div>

                <div class="row" v-show="destino_especial">
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label
                                class="fs-6 fw-semibold mb-2"
                                for="monto_asignado">Origen espacial</label>
                            <input
                                type="text"
                                v-model="origen_espacial_texto"
                                name="origen_espacial_texto"
                                id="origen_espacial_texto"
                                class="form-control form-control-solid">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label
                                class="fs-6 fw-semibold mb-2"
                                for="monto_asignado">Destino espacial</label>
                            <input
                                type="text"
                                v-model="destino_especial_texto"
                                name="destino_especial_texto"
                                id="destino_especial_texto"
                                class="form-control form-control-solid">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label
                                class="fs-6 fw-semibold mb-2"
                                for="nro_folio">Nro folio</label>
                            <input
                                type="text"
                                v-model="nro_folio"
                                name="nro_folio"
                                id="nro_folio"
                                :disabled="true"
                                class="form-control form-control-solid">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label
                                class="fs-6 fw-semibold mb-2"
                                for="monto_asignado">Monto asignado</label>
                            <input
                                type="number"
                                v-model="monto_asignado"
                                name="monto_asignado"
                                id="monto_asignado"
                                class="form-control form-control-solid">
                        </div>
                    </div>
                </div>

                <h3 style="border-bottom: 1px solid #b3b3b3;padding-bottom:5px;margin-top: 20px;margin-bottom:20px">Tripulaciones </h3>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <label class="fs-6 fw-semibold mb-2" for="">Permitir el uso de tripulantes de otra razón social</label>
                    </div>
                    <div class="col-md-4">
                        <!--                    <label class="switch s-icons s-outline s-outline-success  mr-2">
                                                <input type="checkbox" id="otra_razon_social" v-model="otra_razon_social" @change="reseater_lista()"  checked>
                                                <span class="slider"></span>
                                            </label>-->

                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="otra_razon_social"
                                   v-model="otra_razon_social"
                                   @change="reseater_lista()"
                                   checked
                            />
                            <label class="form-check-label fw-semibold text-gray-400 ms-3" for="status"></label>
                        </div>

                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-4">
                        <label class="fs-6 fw-semibold mb-2" for="choferes_select">Conductor de bus #1</label>
                        <select-2
                            name="trabajador_id"
                            v-model="choferes_select"
                            @select-changed="carga_segundo_conductor()"
                            :dataType="'number'"
                        >
                            <option value="">--------</option>
                            <option v-for="({TRABAJADOR_ID,RUT,NOMBRE_COMPLETO}, index) in choferes"  :value="TRABAJADOR_ID">{{RUT+' '+NOMBRE_COMPLETO}}</option>
                        </select-2>

                        <div class="form-check form-switch form-check-custom form-check-solid me-10 mt-5">
                            <input class="form-check-input h-20px w-30px"
                                   v-model="isOtrosTripulante1"
                                   type="checkbox" value="" id="flexSwitch20x30"/>
                            <label class="form-check-label" for="flexSwitch20x30">
                                Reemplazo
                            </label>
                        </div>
                        <div  v-show="isOtrosTripulante1">
                            <select-2
                                v-model="choferes_select_reemplazo"
                                :dataType="'number'"
                              >
                                <option value="">--------</option>
                                <option v-for="({TRABAJADOR_ID,RUT,NOMBRE_COMPLETO}, index) in choferes"  :value="TRABAJADOR_ID">{{RUT+' '+NOMBRE_COMPLETO}}</option>
                            </select-2>
                        </div>


                    </div>
                    <div class="col-md-4">
                        <label class="fs-6 fw-semibold mb-2" for="choferes_select">Conductor de bus #2</label>
                        <select-2
                            :dataType="'number'"
                            v-model="choferes_select_dos"
                            :disabled="segundo_conductor"
                        >
                            <option value="">--------</option>
                            <option v-for="({TRABAJADOR_ID,RUT,NOMBRE_COMPLETO}, index) in conductores"  :value="TRABAJADOR_ID">{{RUT+' '+NOMBRE_COMPLETO}}</option>
                        </select-2>

                        <div class="form-check form-switch form-check-custom form-check-solid me-10 mt-5">
                            <input class="form-check-input h-20px w-30px"
                                   v-model="isOtrosTripulante2"
                                   type="checkbox" value="" id="flexSwitch20x30"/>
                            <label class="form-check-label" for="flexSwitch20x30">
                                Reemplazo
                            </label>
                        </div>

                        <!-- tripulante de reemplazo-->
                        <div  v-show="isOtrosTripulante2">
                            <select-2
                                :dataType="'number'"
                                v-model="choferes_select_dos_reemplazo"
                                :disabled="segundo_conductor"
                                 >
                                <option value="">--------</option>
                                <option v-for="({TRABAJADOR_ID,RUT,NOMBRE_COMPLETO}, index) in conductores"  :value="TRABAJADOR_ID">{{RUT+' '+NOMBRE_COMPLETO}}</option>
                            </select-2>
                        </div>


                    </div>
                    <div class="col-md-4">
                        <label class="fs-6 fw-semibold mb-2" for="auxiliar_select">Auxiliares</label>
                        <select-2
                            name="auxiliar_select"
                            id="auxiliar_select"
                            :dataType="'number'"
                            v-model="auxiliar_select"
                        >
                            <option value="">--------</option>
                            <option v-for="({TRABAJADOR_ID,RUT,NOMBRE_COMPLETO}, index) in auxiliares"  :value="TRABAJADOR_ID">{{RUT+' '+NOMBRE_COMPLETO}}</option>
                        </select-2>

                        <div class="form-check form-switch form-check-custom form-check-solid me-10 mt-5">
                            <input class="form-check-input h-20px w-30px"
                                   v-model="isOtrosTripulante3"
                                   type="checkbox" value="" id="flexSwitch20x30"/>
                            <label class="form-check-label" for="flexSwitch20x30">
                                Reemplazo
                            </label>
                        </div>

                        <div  v-show="isOtrosTripulante3">
                            <select-2
                                :dataType="'number'"
                                v-model="auxiliar_select_reemplazo"
                            >
                                <option value="">--------</option>
                                <option v-for="({TRABAJADOR_ID,RUT,NOMBRE_COMPLETO}, index) in auxiliares"  :value="TRABAJADOR_ID">{{RUT+' '+NOMBRE_COMPLETO}}</option>
                            </select-2>
                        </div>



                    </div>
                </div>


                <div class="row mt-2">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="fs-6 fw-semibold mb-2" for="">Nota de viaje</label>
                            <textarea
                                name="nota_viaje"
                                v-model="nota_viaje"
                                style="width: 100%;height: 200px"
                                class="form-control"
                                id="nota_viaje" >
                        </textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group pt-4">
                            <a href="/viajes" class="btn btn-secondary btn-sm">Volver</a>
                            <button
                                class="btn btn-primary btn-sm"
                                :disabled="isGuardar"
                            >
                                <span v-if="!isGuardar" class="indicator-label">Guardar</span>
                                <span v-else class="indicator-label">Por favor espere...</span>
                                <span v-if="isGuardar" class="indicator-progress">
                                  <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </template>
    </CardComponent>
</template>

<script>
import moment from 'moment';
import Select2 from "../../components/Form/Select2.vue";
import CardComponent from "../../components/CardComponent.vue";
export default {
    components: {
        CardComponent,
        Select2
    },
    data() {
        return {
            choferes:[],
            auxiliares:[],
            choferes_select:'',
            choferes_select_dos:'',
            auxiliar_select:'',
            empleador:[],
            nro_viaje:'',
            clientes:[],
            cliente_id:0,
            empleador_id:0,//ok
            numero_patente:'',//ok
            buses:[],
            bus_id:0,
            numero_bus:0,//ok
            tipo_viaje:'',//ok
            nombre_tripulante:'',//ok
            hora_viaje:'',//ok
            fecha_viaje:'',//ok
            origen_id:0,//ok
            destino_id:0,//ok
            max_tripulantes:2,//ok,
            nro_folio:'',
            monto_asignado:0,
            respuesta:false,
            alerta:'',
            mensajes:'',
            destinos:[],
            tiene_cliente:false,
            nota_viaje:'',
            conductores:[],
            segundo_conductor:true,
            otra_razon_social:false,
            hora_viaje_llegada:'',
            destino_especial:false,
            destino_especial_texto:'',
            origen_espacial_texto:'',
            fecha_llegada:'',
            tiempo_llegada:0,
            last_id:0,
            tramo:0,
            tramos:[],
            isOtrosTripulante1:false,
            isOtrosTripulante2:false,
            isOtrosTripulante3:false,
            choferes_select_reemplazo:0,
            choferes_select_dos_reemplazo:0,
            auxiliar_select_reemplazo:0,
            isGuardar:false,
        }
    },
    created() {
        this.getlastFolio();
    },
    mounted(){
        this.cargarEmpleador()
        this.cargarDestinos()
        this.getBuses()
        this.cargarClientes()
        this.cargar_auxiliares()
        this.cargar_choferes()
        this.cargarTramos()

    },
    updated() {
        // this.refrescar()
        $('#numero_bus').on('select2:select', this.onSelectBuses)
       $('#choferes_select').on('select2:select', this.onSelectConductorOne)
        $('#choferes_select_dos').on('select2:select', this.onSelectConductorTwo)
        $('#auxiliar_select').on('select2:select', this.onSelectAuxiliar)

        $('#choferes_select_change').on('select2:select', this.onSelectConductorReempazoOne)
        $('#choferes_select_change_dos').on('select2:select', this.onSelectConductorReempazoTwo)
        $('#auxiliar_select_change').on('select2:select', this.onSelectAuxiliarReemplazo)
    },
    methods: {
        refrescar:function(){
           // $(this.$refs.buses).selectpicker('refresh')
            //$(this.$refs.choferes1).selectpicker('refresh')
            //$(this.$refs.choferes2).selectpicker('refresh')
            //$(this.$refs.auxiliares).selectpicker('refresh')
        },
        onSelectBuses:function(e){
            const id = e.params.data.id
            //console.log(id)
            this.bus_id = parseInt(id)
            this.filtrar_por_empleador()
            console.log(this.bus_id)
            //this.getViajes()
        },
        onSelectConductorOne:function(e){
            const id = e.params.data.id
            //console.log(id)
            this.choferes_select = parseInt(id)
            this.carga_segundo_conductor()
            console.log(this.choferes_select)
        },
        onSelectConductorTwo:function(e){
            const id = e.params.data.id
            //console.log(id)
            this.choferes_select_dos = parseInt(id)
            console.log(this.choferes_select_dos)
        },
        onSelectAuxiliar:function(e){
            const id = e.params.data.id
            //console.log(id)
            this.auxiliar_select = parseInt(id)
            console.log(this.auxiliar_select)
        },
        onSelectConductorReempazoOne:function(e){
            const id = e.params.data.id
            //console.log(id)
            this.choferes_select_reemplazo = parseInt(id)
            //this.carga_segundo_conductor()
           // console.log(this.choferes_select)
        },
        onSelectConductorReempazoTwo:function(e){
            const id = e.params.data.id
            //console.log(id)
            this.choferes_select_dos_reemplazo = parseInt(id)
           // console.log(this.choferes_select_dos)
        },
        onSelectAuxiliarReemplazo:function(e){
            const id = e.params.data.id
            //console.log(id)
            this.auxiliar_select_reemplazo = parseInt(id)
           // console.log(this.auxiliar_select)
        },
        async cargarRutas(){
            try{
              const {data, status} =  await axios.get('/getRutas?opcion=1&destino_id='+this.destino_id+'&origen_id='+this.origen_id+'&tramo_id='+this.tramo)
                if(status == 200) {
                    const { HORAS_VIAJE } = data
                    this.tiempo_llegada = HORAS_VIAJE
                }
            }catch (error){
                console.log(error)
            }

        },
        async cargarTramos(){
            try {
              const {data , status} = await axios.get('/getTramos')
                if (status == 200) {
                    this.tramos = data
                }
            }catch (error){
                console.log(error)
            }

        },
       async enviarFormulario(){
            try {
                let url = '/viajes'
                this.validar_formulario()
                this.isGuardar = true
                let formData = new FormData();
                formData.append('nro_viaje',this.nro_viaje)
                formData.append('empleador_id',this.empleador_id)
                formData.append('cliente_id',this.cliente_id)
                formData.append('tipo_viaje',this.tipo_viaje)
                formData.append('bus_id',this.bus_id)
                formData.append('hora_viaje',this.hora_viaje)
                formData.append('hora_llegada',this.hora_viaje_llegada)
                formData.append('fecha_llegada',this.fecha_llegada)
                formData.append('fecha_viaje',this.fecha_viaje)
                formData.append('origen_id',this.origen_id)
                formData.append('destino_id',this.destino_id)
                formData.append('nota_viaje',this.nota_viaje)
                // para la tabla de monto_viajes + glosa inicial
                formData.append('nro_folio',this.nro_folio)
                formData.append('monto_asignado',this.monto_asignado)

                if (this.destino_especial){
                    formData.append('viaje_especial',this.destino_especial)
                    formData.append('destino_espacial',this.destino_especial_texto)
                    formData.append('origen_especial',this.origen_espacial_texto)
                }

                //choferes

            /*    formData.append('choferes_uno',this.choferes_select)
                formData.append('choferes_dos',this.choferes_select_dos)
                //auxiliares

                formData.append('auxiliares',this.auxiliar_select)*/

                let tripulacion = [
                    {
                        trabajador_id: this.choferes_select,
                        reemplazo_id: null,
                        tipo_tripulante: "CONDUCTOR_UNO",
                        orden: 1,
                    },
                    ...(this.choferes_select_dos
                        ? [
                            {
                                trabajador_id: this.choferes_select_dos,
                                reemplazo_id: null,
                                tipo_tripulante: "CONDUCTOR_DOS",
                                orden: 2,
                            },
                        ]
                        : []),
                    ...(this.auxiliar_select
                        ? [
                            {
                                trabajador_id: this.auxiliar_select,
                                reemplazo_id: null,
                                tipo_tripulante: "AUXILIAR",
                                orden: 3,
                            },
                        ]
                        : []),
                ];

                //solo si el conductor 1 tiene reemplazo
                if (this.choferes_select_reemplazo > 0) {
                    tripulacion.push({
                        trabajador_id: this.choferes_select_reemplazo,
                        reemplazo_id: this.choferes_select,
                        tipo_tripulante: "CONDUCTOR_UNO_REEMPLAZO",
                        orden: 4,
                    });
                }

                //solo si el conductor 2 tiene reemplazo
                if (this.choferes_select_dos_reemplazo > 0) {
                    tripulacion.push({
                        trabajador_id: this.choferes_select_dos_reemplazo,
                        reemplazo_id: this.choferes_select_dos,
                        tipo_tripulante: "CONDUCTOR_DOS_REEMPLAZO",
                        orden: 4,
                    });
                }

                //solo si el auxiliar tiene reemplazo
                if (this.auxiliar_select_reemplazo > 0) {
                    tripulacion.push({
                        trabajador_id: this.auxiliar_select_reemplazo,
                        reemplazo_id: this.auxiliar_select,
                        tipo_tripulante: "AUXILIAR_REEMPLAZO",
                        orden:4
                    });
                }

                //VALIDA QUE EL ARRAY NO POSEA MAS DE 4 ELEMENTOS
                if (tripulacion.length > 4) {
                    this.$swal.fire({
                        title: "Error",
                        text: "Solo puede seleccionar 3 tripulantes y un reemplazo",
                        icon: "error",
                    });
                    return;
                }


                formData.append('tripulacion', JSON.stringify(tripulacion));




                 const {status} = await axios.post(url,formData)

                if (status == 200){
                    //this.respuesta = true
                    //this.alerta= 'alert-success'
                    //this.mensajes = 'Viaje Creado exitosamente'
                    //this.$swal('Viaje creado exitosamente')
                    this.isGuardar = false
                    this.$swal.fire({
                        title: 'Viaje creado exitosamente',
                        text: "¿Desea crear otro viaje?",
                        icon: 'success',
                        //html custom button redirect a la pagina de viajes
                        html: `<a href="/generar-folio/${this.nro_folio}" target="_blank"  class="btn btn-success">Imprimir folio</a>`,
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.value) {
                            this.limpiarFormulario()
                        }else{
                            window.location.href = "/viajes";
                        }
                    })

                }

            }catch (error){
                this.$swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Algo salio mal!',
                })
            }
       },
        imprimirFolio(nro_folio){
            window.open('/generar-folio/'+nro_folio, '_blank');
        },
        validar_formulario(){
          if (this.bus_id == 0){
              this.$swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Debe seleccionar un empleador!',
              })
              return false
          }
            if (this.nro_viaje === ''){
               this.$swal.fire(
                     'Oops...',
                     'Debe ingresar un numero de viaje!',
                     'error'
                )
                 return false
            }

        },
        limpiarFormulario(){
            //limpiar formulario
            this.nro_viaje = ''
            this.empleador_id = 0
            this.cliente_id = 0
            this.tipo_viaje = ''
            this.bus_id = 0
            this.hora_viaje = ''
            this.hora_viaje_llegada = ''
            this.fecha_viaje = ''
            this.origen_id = ''
            this.destino_id = ''
            this.nota_viaje = ''
            this.nro_folio = ''
            this.monto_asignado = ''
            this.destino_especial = ''
            this.destino_especial_texto = ''
            this.origen_espacial_texto = ''
            this.choferes_select = 0
            this.choferes_select_dos = 0
            this.auxiliar_select = 0
            //limpiar select2
            this.getlastFolio()
        },
       async cargarEmpleador(){
            try {
                const {data, status} = await axios.get('/empleador')
                if(status == 200) {
                    this.empleador = data
                }
            }
            catch (error){
                console.log(error)
            }
        },
        filtrar_por_empleador:function (){
             let bus_empleador =  this.buses.find((item) => item.id === this.bus_id)

             this.empleador_id = bus_empleador.empleador_id

             this.cargar_auxiliares()
              this.cargar_choferes()
              //this.getBuses()
        },
        async cargar_auxiliares(){
            try {
                let url = '/getTripulacion?filtro[CARGO_ID]=2&opcion=3&filtro[CONDICION]=disponible'

                if (this.empleador_id !== 0) {
                    if (this.otra_razon_social) {
                        url = '/getTripulacion?filtro[CARGO_ID]=2&opcion=3&filtro[CONDICION]=disponible'
                    } else {
                        url = url + '&filtro[EMPLEADOR_ID]=' + this.empleador_id
                    }
                }

                const {data, status} = await axios.get(url)

                if (status == 200) {
                    this.auxiliares = data
                }

            }catch (error){
                console.log(error)
            }
        },
        async cargar_choferes(){
            try {
                let url = '/getTripulacion?filtro[CARGO_ID]=3&opcion=2&filtro[CONDICION]=disponible'

                if (this.empleador_id !== 0){
                    if (this.otra_razon_social) {

                        url = '/getTripulacion?filtro[CARGO_ID]=3&opcion=2&filtro[CONDICION]=disponible'

                    }else{
                        url = url + '&filtro[EMPLEADOR_ID]=' + this.empleador_id
                    }
                }

               const {data, status} = await axios.get(url)

                if (status == 200) {
                    this.choferes = data
                    this.conductores = data
                }

            }catch (error){
                console.log(error)
            }

        },
        async cargarDestinos(){
            try {
                const {data, status} = await axios.get('/destinos')
                if(status == 200) {
                    this.destinos = data
                }
            }
            catch (error){
                console.log(error)
            }
        },
        async cargarClientes(){
            try {
                const {data , status} = await axios.get('/clientes')
                if (status == 200) {
                    this.clientes = data
                }
            }catch (error){
                console.log(error)
            }
        },
       async getBuses(){
            try {
                let  url = '/getBusesLista?operador=lista&estado=Bus operativo'

                if (this.empleador_id !== 0){
                    url = url + '&filtro[empleador_id]='+this.empleador_id
                }

                const {data , status} = await axios.get(url)

                if (status == 200) {
                    this.buses = data
                }
            }catch (error){
                console.log(error)
            }
        },
        es_servicio_mineria:function (){
              if(this.tipo_viaje === 'servicio en mineria'){
                  // GENERAR UN NUMERO SECUENCIA DESDE LA BASE DE DATOS
                     axios.get('/ultimoViaje').then((res)=>{
                        // console.log(res.data)
                         this.last_id = res.data.id
                         this.nro_viaje = 'SMIN-'+this.last_id
                    })
                        this.tiene_cliente = true

              }else{
                  this.nro_viaje = ''
                  this.tiene_cliente = false
              }
        },
        async getlastFolio(){
            try {
                const {data , status} = await axios.get('/obtener-ultimo-folio')
                if (status == 200) {

                    this.nro_folio = parseInt(data)
                    console.log(data)
                }
            }catch (error){
                console.log(error)
            }

        },
        carga_segundo_conductor:function (){
            this.segundo_conductor = false
            this.conductores = this.choferes.filter(item => item.TRABAJADOR_ID !== this.choferes_select)
        },
        reseater_lista:function (){

                this.cargar_choferes()
                this.cargar_auxiliares()

        },
        aparecer_destino_especial (){

        },
        determina_hora_llegada (){
           let  hora = this.hora_viaje
            let  hora_llegada = moment(this.fecha_viaje+' '+hora).add(this.tiempo_llegada,'hours').format('HH:mm');
            let  fecha_llegada = moment(this.fecha_viaje+' '+hora).add(this.tiempo_llegada,'hours').format('YYYY-MM-DD');
           // console.log(moment(hora).add(10,'hours').format('HH:mm'))
           console.log(fecha_llegada)
            this.fecha_llegada = fecha_llegada
            this.hora_viaje_llegada = hora_llegada
        },
        async getMontoDestino(){
           try {
                let url = '/monto-destino/'+this.destino_id

                const {data , status} = await axios.get(url)

                if (status == 200) {
                    this.monto_asignado = data?.monto_predeterminado ? data?.monto_predeterminado : 0
                }
           }catch (error){
                console.log(error)
           }
        },

    },
}
</script>

<style scoped>

</style>
