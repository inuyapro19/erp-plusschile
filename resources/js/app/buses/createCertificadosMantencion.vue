<template>
    <CardComponent>


       <template #body>
           <form @submit.prevent="enviarFormulario()">
               <div class="row">
                   <div class="col-md-4 form-group">
                       <label class="fs-6 fw-semibold mb-2" for="numero_bus">Bus + patente</label>
                       <select-2
                           v-model="bus_id"
                           dataType="number"
                       >
                           <option value="">----------------------</option>
                           <option  v-for="(bus, index) in buses" :value="bus.id">{{bus.numero_bus + ' - '+ bus.patente }}</option>
                       </select-2>
                   </div>
               </div>
               <div class="row">

                   <div class="col-md-4 form-group">
                       <label class="fs-6 fw-semibold mb-2" for="tipo_certificado">Tipo certificado</label>
                       <select name="tipo_certificado" v-model="tipo_certificado" @change="cambiar_tipo_form()" id="tipo_certificado" class="form-select form-select-solid">
                           <option value="">-------</option>
                           <option v-for="(tipo_certificado, index) in tipos_certificados" :value="tipo_certificado">{{tipo_certificado}}</option>
                       </select>
                   </div>
                   <div class="col-md-4 form-group">
                       <label class="fs-6 fw-semibold mb-2" for="">Certificado pdf</label>
                       <input   ref="certificado_pdf"  id="file-upload" class="form-control form-control-solid"  type="file" aria-label="Adjunte archivo de contrato" @change.prevent="onFileChangeContrato()"    accept=".pdf" />
                   </div>
               </div>
               <div class="row">
                   <div class="col-md-4 form-group">
                       <label class="fs-6 fw-semibold mb-2" for="fecha_emision">Fecha Emisión</label>
                       <input type="date" v-model="fecha_emision" id="fecha_emision" class="form-control" >
                   </div>
                   <div class="col-md-4 form-group">
                       <label class="fs-6 fw-semibold mb-2" for="fecha_vencimiento">Fecha Vencimiento</label>
                       <input type="date" v-model="fecha_vencimiento" id="fecha_vencimiento" class="form-control" >
                   </div>
               </div>
               <div class="row" v-show="certificado_de_gases">
                   <div class="col-md-4 form-group">
                       <label class="fs-6 fw-semibold mb-2" for="fecha_emision_gases">Fecha Emisión de certificados de gases</label>
                       <input type="date" v-model="fecha_emision_gases" id="fecha_emision_gases" class="form-control" >
                   </div>
                   <div class="col-md-4 form-group">
                       <label class="fs-6 fw-semibold mb-2" for="fecha_vencimiento_gases">Fecha vencimiento de certificados de gases</label>
                       <input type="date" v-model="fecha_vencimiento_gases" id="fecha_vencimiento_gases" class="form-control" >
                   </div>
               </div>
               <div class="row" v-show="certificado_seguro_soap">
                   <div class="col-md-4 form-group">
                       <label class="fs-6 fw-semibold mb-2" for="compania">Compañia</label>
                       <input type="text" v-model="compania_seguro" id="compania" class="form-control" >
                   </div>
               </div>
               <div class="row" v-show="certificado_permiso_circulacion">
                   <div class="col-md-4 form-group">
                       <label class="fs-6 fw-semibold mb-2" for="municipalidad">Municipaliad otorgante</label>
                       <input type="text" v-model="municipalidad_emisora" id="municipalidad" class="form-control" >
                   </div>
               </div>
               <div class="row" v-show="certificado_carton_de_recorrido">
                   <div class="col-md-4 form-group">
                       <label class="fs-6 fw-semibold mb-2" for="nro_certificado">Nro Certificado</label>
                       <input type="text" v-model="nro_certificado" id="nro_certificado" class="form-control" >
                   </div>
                   <div class="col-md-4 form-group">
                       <label class="fs-6 fw-semibold mb-2" for="fecha_inicio_vehiculo">Fecha inicio vehiculo</label>
                       <input type="date" v-model="fecha_inicio_vehiculo" id="fecha_inicio_vehiculo" class="form-control" >
                   </div>
                   <div class="col-md-4 form-group">
                       <label class="fs-6 fw-semibold mb-2" for="fecha_vencimiento_vehiculo">Fecha vencimiento vehiculo</label>
                       <input type="date" v-model="fecha_vencimiento_vehiculo" id="fecha_vencimiento_vehiculo" class="form-control" >
                   </div>
                   <div class="col-md-4 form-group">
                       <label class="fs-6 fw-semibold mb-2" for="fecha_inicio_servicio">Fecha inicio servicio</label>
                       <input type="date" v-model="fecha_inicio_servicio" id="fecha_inicio_servicio" class="form-control" >
                   </div>
                   <div class="col-md-4 form-group">
                       <label class="fs-6 fw-semibold mb-2" for="fecha_vencimiento_servicio">Fecha vencimiento servicio</label>
                       <input type="date" v-model="fecha_vencimiento_servicio" id="fecha_vencimiento_servicio" class="form-control form-control-solid" >
                   </div>
                   <div class="col-md-12">
                       <h3>Recorridos</h3>
                   </div>
                   <div class="col-md-4">
                       <div class="form-group">
                           <label class="fs-6 fw-semibold mb-2" for="origen_id">Origen</label>
                           <select name="origen_id" class="form-select form-select-solid" v-model="origen_id" id="origen_id">
                               <option value="">----------</option>
                               <option v-for="(destino, index) in destinos" :value="destino.id">{{destino.ciudad}}</option>
                           </select>
                       </div>
                   </div>
                   <div class="col-md-4">
                       <div class="form-group">
                           <label class="fs-6 fw-semibold mb-2" for="destino_id">Destino</label>
                           <select name="destino_id" class="form-select form-select-solid" v-model="destino_id" id="destino_id">
                               <option value="">----------</option>
                               <option v-for="(destino, index) in destinos" :value="destino.id">{{destino.ciudad}}</option>
                           </select>
                       </div>
                   </div>
                   <div class="col-md-8 form-group">
                       <label class="fs-6 fw-semibold mb-2" for="trazado_principal_ida">Trazado principal ida</label>
                       <textarea name="" v-model="trazado_principal_ida" id="trazado_principal_ida" class="form-control form-control-solid" style="width: 100%;height: 250px"></textarea>
                   </div>
                   <div class="col-md-8 form-group">
                       <label class="fs-6 fw-semibold mb-2" for="trazado_principal_regreso">Trazado principal regreso</label>
                       <textarea name="" v-model="trazado_principal_regreso" id="trazado_principal_regreso" class="form-control form-control-solid" style="width: 100%;height: 250px"></textarea>
                   </div>
                   <div class="col-md-12 mt-5">
                       <button type="button" class="btn btn-primary btn-sm" @click.prevent="addRecorrido()"><i class="fa fa-plus-square"></i> Agregar</button>
                   </div>

                   <div class="col-md-12">
                       <SimpleTable :data="recorridos" :columns="columns" @delete="eliminarRecorrido"></SimpleTable>
                   </div>

               </div>

              <div class="col-md-12 mt-5">
                  <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                  <a href="/certificado-buses" class="btn btn-default btn-sm">Volver</a>
              </div>
           </form>
       </template>

    </CardComponent>
</template>

<script>
import CardComponent from '@/components/CardComponent.vue'
import Select2 from "@/components/Form/Select2.vue";
import SimpleTable from "../../components/simpleTable.vue";
const shortid = require('shortid');
export default {
    components:{
        SimpleTable,
        Select2,
        CardComponent
    },
    props:{
        id:{
            type:Number,
            required:false
        },
        edit:{
            type:Boolean,
            required: false,
        }
    },
    data() {
        return {
            buses:[],
            bus_id:0,
            patente:'',
            numero_bus:0,
            tipo_certificado:'',
            certificados:[],
            tipos_certificados:['REVISION TECNICA + CERTIFICADO DE GASES','SEGUROS SOAP','PERMISO CIRCULACION','CERTIFICADO SERVICIO ESPECIAL','CARTÓN DE RECORRIDO'],
            fecha_vencimiento:'',
            fecha_emision:'',
            fecha_emision_gases:'',
            fecha_vencimiento_gases:'',
            compania_seguro:'',
            municipalidad_emisora:'',
            nro_certificado:'',
            fecha_inicio_vehiculo:'',
            fecha_vencimiento_vehiculo:'',
            fecha_inicio_servicio:'',
            fecha_vencimiento_servicio:'',
            origen_id:0,//ok
            destino_id:0,//ok
            destinos:[],
            trazado_principal_ida:'',
            trazado_principal_regreso:'',
            recorridos:[],
            certificado_de_gases:false,
            certificado_seguro_soap:false,
            certificado_permiso_circulacion:false,
            certificado_servicio_espacial:false,
            certificado_carton_de_recorrido:false,
            certificado_pdf:'',
            columns: [
                { title: 'Origen', field: 'origen' },
                { title: 'Destino', field: 'destino' },
                { title: 'Trazado principal ida', field: 'trazado_principal_ida' },
                { title: 'Trazado principal regreso', field: 'trazado_principal_regreso' },
                { title: 'Acciones', field: 'acciones' },
            ],
            //si el tipo de certificado fuera recorrido
        }
    },
    mounted() {
        this.getBuses()
    },
    updated() {
        this.refrescar()
    },
    methods:{
        async getBuses (){
            let url = '/getBuses?operador=first'

            await axios.get(url).then((res)=> {
                this.buses = res.data

            }).catch((error)=>{
                console.log(error)
            })
        },
        refrescar:function(){
            $(this.$refs.buses).selectpicker('refresh')
        },
        async cargarDestinos(){
            await axios.get('/destinos').then(res => {
                this.destinos = res.data
            }).catch(error =>{
                console.log(error)
            })
        },
        async enviarFormulario () {
            let formData = new FormData()
            let url = ''
            formData.append('bus_id',this.bus_id)
            formData.append('tipo_certificado',this.tipo_certificado)

         if (this.tipo_certificado===''){
                this.$swal('Debe seleccionar tipo de certificado')
                return;
            }

            if (this.tipo_certificado === 'REVISION TECNICA + CERTIFICADO DE GASES'){
                formData.append('fecha_vencimiento',this.fecha_vencimiento)
                formData.append('fecha_emision',this.fecha_emision)
                formData.append('fecha_vencimiento',this.fecha_vencimiento)
                formData.append('fecha_emision',this.fecha_emision)
            }

            if (this.tipo_certificado === 'SEGUROS SOAP'){
                formData.append('fecha_vencimiento',this.fecha_vencimiento)
                formData.append('fecha_emision',this.fecha_emision)
                formData.append('compania_seguro',this.compania_seguro)
            }

            if (this.tipo_certificado === 'PERMISO CIRCULACION'){
                formData.append('fecha_vencimiento',this.fecha_vencimiento)
                formData.append('fecha_emision',this.fecha_emision)
                formData.append('municipalidad',this.municipalidad_emisora)
            }

            if (this.tipo_certificado === 'CERTIFICADO SERVICIO ESPECIAL'){
                formData.append('fecha_vencimiento',this.fecha_vencimiento)
                formData.append('fecha_emision',this.fecha_emision)
            }

            if (this.tipo_certificado === 'CARTÓN DE RECORRIDO'){
                formData.append('fecha_vencimiento',this.fecha_vencimiento)
                formData.append('fecha_emision',this.fecha_emision)
            }

            if(this.tipo_certificado == 'CARTÓN DE RECORRIDO'){

                formData.append('nro_certificado',this.nro_certificado)
                formData.append('fecha_emision',this.fecha_emision)
                formData.append('fecha_inicio_vehiculo',this.fecha_inicio_vehiculo)
                formData.append('fecha_vencimiento_vehiculo',this.fecha_vencimiento_vehiculo)
                formData.append('fecha_inicio_servicio',this.fecha_inicio_servicio)
                formData.append('fecha_vencimiento_servicio',this.fecha_vencimiento_servicio)

                let recorridos = []
                recorridos.push(this.recorridos)
                formData.append('recorridos',JSON.stringify(recorridos))
            }

           //certificado pdf

            formData.append('certificado_pdf', this.certificado_pdf)

            if (this.edit){
                let url = '/certificado-buses-add/'+this.id_certificado
            }else{
                let url = '/certificado-buses-add'
            }

            await axios.post('/certificado-buses-add',formData,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((res)=>{

                if (this.edit){
                    this.$swal('Certificado editado exitosamente');
                }else{
                    this.$swal('Certificado agregado exitosamente');
                    window.location.href = "/certificado-buses";
                }

            }).catch((error)=>{
                this.$swal('error al enviar el formulario');
            })

        },
        cambiar_tipo_form:function (){
            let tipo_certificado =  this.tipo_certificado
            if (this.tipo_certificado !== ''){
                if(tipo_certificado == 'REVISION TECNICA + CERTIFICADO DE GASES'){
                    this.certificado_de_gases = true
                }else{
                    this.certificado_de_gases = false
                }

                if(tipo_certificado == 'SEGUROS SOAP'){
                    this.certificado_seguro_soap = true
                }else{
                    this.certificado_seguro_soap = false
                }

                if(tipo_certificado == 'PERMISO CIRCULACION'){
                    this.certificado_permiso_circulacion = true
                }else{
                    this.certificado_permiso_circulacion = false
                }

                if(tipo_certificado == 'CERTIFICADO SERVICIO ESPECIAL'){
                    this.certificado_servicio_espacial = true
                }else{
                    this.certificado_servicio_espacial = false
                }

                if(tipo_certificado == 'CARTÓN DE RECORRIDO'){
                    this.certificado_carton_de_recorrido = true
                    this.cargarDestinos()
                }else{
                    this.certificado_carton_de_recorrido = false
                }

            }else{
                this.$swal('debe seleccionar tipo de certificado')
            }


        },
        addRecorrido:function (){

            let id = shortid.generate()

            if (this.origen_id < 1){
                this.$swal('DEBE SELECCIONA ORIGEN')
                return
            }

            if (this.destino_id < 1){
                this.$swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: '<a href="">Why do I have this issue?</a>'
                })
                return
            }

            let origen = this.destinos.find(item => item.id === this.origen_id)
            let destino = this.destinos.find(item => item.id === this.destino_id)
            //console.log(origen)

            this.recorridos.push({
                id:id,
                origen:origen.ciudad,
                origen_id:this.origen_id,
                destino:destino.ciudad,
                destino_id:this.destino_id,
                trazado_principal_ida:this.trazado_principal_ida,
                trazado_principal_regreso:this.trazado_principal_regreso
            })

            this.origen_id = 0
            this.destino_id = 0
            this.trazado_principal_ida = ''
            this.trazado_principal_regreso = ''

            if (this.recorridos.length > 0){
                this.$swal('Recorrido agregado exitosamente')
            }else{
                this.$swal('Error al agregar recorrido')
            }

        },
        eliminarRecorrido:function (id){
            this.recorridos = this.recorridos.filter(item => item.id !== id)
            this.$swal('Recorrido eliminado')
        },
        onFileChangeContrato() {
            //console.log(e.target.files[0]);
            //this.filename =   this.$certificado.file.files[0].name;
            // this.size =  this.file = this.$certificado.file.files[0].size;
            this.certificado_pdf = this.$refs.certificado_pdf.files[0];
        },
        onFileChangeCertificado:function (){
            this.certificado_pdf = this.$refs.certificado_pdf.files[0];
        },
    }
}
</script>

<style scoped>

</style>
