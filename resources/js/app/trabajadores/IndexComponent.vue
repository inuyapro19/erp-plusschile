<template>
    <CardComponent :is-header="true">
            <template #header >
                <div class="acciones" v-show="editar">
                    <div class="btn-group">
                        <Desvinculacion :id="id"/>
                        <button type="button" class="btn btn-info btn-sm ml-4" @click="editarFicha"><i class="fa fa-edit"></i> Editar</button>
                    </div>

                </div>
            </template>
          <template #body>
              <form  id="form-contactos" @submit.prevent="enviarFormulario">

                  <ul class="nav nav-tabs  mb-3 mt-3" id="simpletab" role="tablist">
                      <li class="nav-item">
                          <a class="nav-link active" id="ficha-tab" data-toggle="tab" href="#ficha" role="tab" aria-controls="home" aria-selected="true">Ficha Trabajador</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" id="controtao-tab" data-toggle="tab" href="#contrato" role="tab" aria-controls="contrato" aria-selected="true">Datos Contractuales</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" id="prevision-tab" data-toggle="tab" href="#prevision" role="tab" aria-controls="prevision" aria-selected="true">Regimen Previsional</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" id="salud-tab" data-toggle="tab" href="#salud" role="tab" aria-controls="salud" aria-selected="true">Salud</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" id="voluntario-tab" data-toggle="tab" href="#voluntario" role="voluntario-tab" aria-controls="voluntario" aria-selected="true">Ahorro Voluntario</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" id="contacto-tab" data-toggle="tab" href="#contacto" role="tab" aria-controls="bancario" aria-selected="true">Datos de Contactos</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" id="bancorio-tab" data-toggle="tab" href="#bancario" role="tab" aria-controls="bancario" aria-selected="true">Datos Bancarios</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" v-show="licencia_conducir" id="licencia-tab" data-toggle="tab" href="#licencia" role="tab" aria-controls="licenbcia" aria-selected="true">Licencia Conducir</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" v-show="formulario.tiene_familia" id="carga-tab" data-toggle="tab" href="#lista_familiar" role="tab" aria-controls="lista_familiar" aria-selected="true">Carga Familiares</a>
                      </li>
                  </ul>
                  <div class="tab-content" id="simpletabContent">
                      <div class="tab-pane fade show active" id="ficha" role="tabpanel" aria-labelledby="ficha-tab">
                          <Ficha
                              :formulario="formulario"
                              :errors="errors"
                              :inputClass="inputClass"
                              :errorsClass="errorsClass"
                              :regiones="regiones"
                              :comunas="comunas"
                              :cargaFamilar="cargaFamilar"
                              :editarTrabajador="editarTrabajador"
                              :selectClass="selectClass"
                          />

                      </div>
                      <div class="tab-pane fade" id="contrato" role="tabpanel" aria-labelledby="contrato-tab">
                          <Contrato
                              :contrato="contrato"
                              :errors="errors"
                              :inputClass="inputClass"
                              :errorsClass="errorsClass"
                              :editarTrabajador="editarTrabajador"
                          />
                      </div>
                      <div class="tab-pane fade" id="prevision" role="tabpanel" aria-labelledby="contrato-tab">
                          <Previsiones
                              :errors="errors"
                              :inputClass="inputClass"
                              :errorsClass="errorsClass"
                              :editarTrabajador="editarTrabajador"
                          />
                      </div>
                      <div class="tab-pane fade" id="salud" role="tabpanel" aria-labelledby="contrato-tab">
                          <Salud
                              :editarTrabajador="editarTrabajador"
                          />
                      </div>
                      <div class="tab-pane fade" id="voluntario" role="tabpanel" aria-labelledby="voluntario-tab">
                          <ahorro-voluntatario
                              :editarTrabajador="editarTrabajador"
                          />
                      </div>
                      <div class="tab-pane fade" id="contacto" role="tabpanel" aria-labelledby="contacto-tab">
                          <Contacto
                              :regiones="regiones"
                              :editarTrabajador="editarTrabajador"
                          />
                      </div>
                      <div class="tab-pane fade" id="bancario" role="tabpanel" aria-labelledby="bancorio-tab">
                          <Bancos
                              :bancoTrabajador="bancoTrabajador"
                              :editarTrabajador="editarTrabajador"
                          />
                      </div>
                      <div class="tab-pane fade" id="licencia" role="tabpanel" aria-labelledby="licencia-tab">
                          <Licencia
                              :editarTrabajador="editarTrabajador"
                          />
                      </div>
                      <div class="tab-pane fade" id="lista_familiar" role="tabpanel" aria-labelledby="carga-tab">
                          <CargaFamiliarTab
                              :editarTrabajador="editarTrabajador"
                          />
                      </div>

                  </div>
                  <div class="flex-center">
                      <button type="submit"  class="btn btn-primary btn-sm" :disabled="editarTrabajador">GUARDAR</button>
                      <a href="/trabajadores" class="btn btn-light me-3">Volver</a>
                  </div>
              </form>
          </template>
    </CardComponent>

</template>

<script>

import Ficha from "./formularios/Ficha";
import Bancos from "./formularios/Bancos";
import Contrato from "./formularios/Contrato";
import Contacto from "./formularios/Contacto";
import Licencia from "./formularios/Licencia";
import Desvinculacion from "./formularios/Desvinculacion";
import CargaFamiliarTab from "./formularios/cargaFamiliarTab";
import Previsiones from "./formularios/Previsiones";
import Salud from "./formularios/Salud";
import {mapActions, mapState} from "vuex";
import {cargarTrabajadorEdit} from "../../modulos/trabajador/actions";
import {cargarContactoEdit} from "../../modulos/contacto/actions";
import AhorroVoluntatario from "./formularios/ahorroVoluntatario";
import {getAhorrosEdit} from "../../modulos/Ahorro/actions";
import {cargarPrevisionEdit} from "../../modulos/prevision/actions";
import {cargarSaludEdit} from "../../modulos/salud/actions";
import CardComponent from "../../components/CardComponent.vue";


export default {
    props:{
       id:{
           type:Number,
           required:false,
           default: 0
       },
        editar:{
           type:Boolean,
            default:false
        }
    },
    components:{
        CardComponent,
      AhorroVoluntatario,
      Ficha,
      Contrato,
      Bancos,
      Contacto,
      Licencia,
      Desvinculacion,
      CargaFamiliarTab,
      Previsiones,
      Salud
  },
    computed:{
        ...mapState('trabajador',['licencia_conducir','formulario','allDatos']),
        ...mapState('contacto',['contacto']),
        ...mapState('bancos',['bancotrabajadores']),
        ...mapState('cargaFamiliar',['cargasFamiliares']),
        ...mapState('prevision',['prevision']),
        ...mapState('Salud',['salud']),
        ...mapState('Ahorro',['ahorros']),
        ...mapState('licencia',['licencia','licencias']),
        ...mapState('Enfermedad',['salud_discapacidad','salud_enfemedades'])
    },
    data(){
        return {
            contrato:{
                empleador_id:'',
                fecha_ingreso:'',
                fecha_antiguidad:'',
                fecha_vencimiento_contrato:'',
                fecha_vencimiento_contrato_segundo:'',
                ubicacion_id:'',
                prevision_id:'',
                salud_id:'',
                area_id:'',
                cargo_id:'',
                centro_costo:'',
                tipo_jornada:'',
                jornada_excepcional: '',
                tipo_contrato:'',
                sueldo_base_anterior:'',
                sueldo_base:0,
                gratificacion:0
            },
            licencia:[],
            bancoTrabajador:[],
            cargaFamilar:[],
            buscador_codigo_trabajador:'',
            respuesta:false,
            alerta:'',
            mensajes:'',
            errors:[],
            regiones:[],
            comunas:[],
            inputClass:'form-control form-control-solid',
            selectClass:'form-select form-select-solid',
            errorsClass:'',
            ubicaciones:[],
            editarTrabajador:false
        }
    },
    created() {
        this.cargarTrabajador()
        this.cargarContrato()
        this.cargarContacto()
        this.getCargaFamiliar()
        this.getBancoEdit()
        this.getCargaAhorros()
        this.getCargaPrevision()
        this.getCargaSalud()
    },
    mounted() {
      this.cargarState()
        this.editarFicha()
    },
    methods:{
        ...mapActions('contacto',['reset_contacto','cargarContactoEdit','comprobar_maximo']),
        ...mapActions('trabajador',['cargarTrabajadorEdit']),
        ...mapActions('cargaFamiliar',['cargaFamiliarEdit']),
        ...mapActions('bancos',['getBancoTrabajadorEdit']),
        ...mapActions('Ahorro',['getAhorrosEdit']),
        ...mapActions('prevision',['cargarPrevisionEdit']),
        ...mapActions('Salud',['cargarSaludEdit']),

        async cargarState(){
            try{
                const {data ,status} = await axios.get('/regiones')
                if (status === 200){
                    this.regiones = data
                }
            }catch (e) {
                console.log(e)
            }
        },
         async cargarCities(){
           try{
                    const {data ,status} = await axios.get('/comunas/'+this.contacto.region_id)
                    if (status === 200){
                        this.formulario.comuda_id = '0'
                        this.comunas = data
                    }
                }catch (e) {
                    console.log(e)
                }
        },
        cargarTrabajador() {
            try {
                let id = this.id !== 0 ? this.id : 0
                if(id>0){
                    this.cargarTrabajadorEdit(id)
                }
                else{
                    /*this.$swal.fire({
                        title: 'Error!',
                        text: 'No se encontro el trabajador',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    })*/
                    return;
                }
            }catch (e) {
                console.log(e)
            }

        },
       async cargarContrato ()
        {
            try {
                let id = this.id !== 0 ? this.id : 0
                if(id>0){
                   const {data, status} =await  axios.get('/cargaContrato/'+id)
                    if (status === 200){
                        this.contrato = {
                            empleador_id:data.empleador_id,
                            fecha_ingreso:data.fecha_ingreso,
                            ubicacion_id:data.ubicacion_id,
                            prevision_id:data.prevision_id,
                            salud_id:data.salud_id,
                            area_id:data.area_id,
                            cargo_id:data.cargo_id,
                            centro_costo:data.centro_costo,
                            tipo_jornada:data.tipo_jornada,
                            fecha_antiguidad:data.fecha_antiguidad,
                            fecha_vencimiento_contrato:data.fecha_vencimiento_contrato,
                            fecha_vencimiento_contrato_segundo:data.fecha_segundo_vencimiento,
                            tipo_contrato:data.tipo_contrato
                        }
                    }
                }
                else{
                  /*  this.$swal.fire({
                        title: 'Error!',
                        text: 'No se encontro el trabajador',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    })*/
                    return;
                }
            }catch (e) {
                /*this.$swal.fire({
                    title: 'Error!',
                    text: 'No se encontro el trabajador',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                })*/
            }
        },
        async cargarContacto(){
            try{
                let id = this.id
                const {data,status} = await axios.get('/cargaContacto/'+id)

                if(status === 200){
                    this.cargarContactoEdit(data)
                    this.comprobar_maximo()
                }
            }catch (e) {
              /*  this.$swal.fire({
                    title: 'Error!',
                    text: 'No se encontro el trabajador',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                })*/
            }

        },
       async getCargaFamiliar(){
            try {
                let id = this.id
                const {data, status} = await axios.get('/cargaFamiliar/'+id)

                if (status === 200){
                    this.cargaFamiliarEdit(data)
                }
            }catch (e) {
                console.log(e)
            }

        },
       async getBancoEdit(){
           try {
                let id = this.id
                const {data, status} = await axios.get('/cargaBancos/'+id)

                if (status === 200){
                     this.getBancoTrabajadorEdit(data)
                }
           }catch (e) {
               console.log(e)
           }
        },
       async getCargaAhorros(){
            try {
                let id = this.id
                const {data, status} = await  axios.get('/cargaPrevisiones/'+id)

                if (status === 200){
                    this.cargarPrevisionEdit(data)
                }

            }catch (e) {
                console.log(e)
            }

        },
       async getCargaPrevision(){
            try {
                let id = this.id
                const {data, status} = await axios.get('/cargaAhorros/'+id)

                if (status === 200){
                    this.getAhorrosEdit(data)
                }
            }catch (e) {
                console.log(e)
            }
        },
       async getCargaSalud(){
            try {
                let id = this.id
                const {data, status} = await  axios.get('/cargaSalud/'+id)

                if (status === 200){
                    this.cargarSaludEdit(data)
                }
            }catch (e) {
                console.log(e)
            }

        },
       async  enviarFormulario (event)
        {
            let formData = new FormData();
            /* ficha trabajador */
            formData.append('rut',this.formulario.rut)
            formData.append('primer_nombre',this.formulario.primer_nombre)
            formData.append('segundo_nombre',this.formulario.segundo_nombre)
            formData.append('primer_apellido',this.formulario.primer_apellido)
            formData.append('segundo_apellido',this.formulario.segundo_apellido)
            formData.append('fecha_nac',this.formulario.fecha_nac)
            formData.append('estado_civil',this.formulario.estado_civil)
            formData.append('sexo',this.formulario.sexo)
            formData.append('telefono_celular',this.formulario.telefono_obligatorio)
            formData.append('telefono_local',this.formulario.telefono_opcional)
            formData.append('correo',this.formulario.correo)
            formData.append('confirmar_correo',this.formulario.confirmar_correo)
            formData.append('direccion',this.formulario.direccion)
            formData.append('region_id',this.formulario.region_id)
            formData.append('comuna_id',this.formulario.comuna_id)
            formData.append('nacionalidad',this.formulario.nacionalidad)
            formData.append('carga_familiar',this.formulario.tiene_familia)/* carga familiar */
            formData.append('pertenece_pueblo_originario',this.formulario.perteneces_pueblo_originario)
            formData.append('pueblo_originario_id',this.formulario.pueblo_originario_id)
            formData.append('tiene_alguna_discapacidad',this.formulario.tiene_discapacidad)
            formData.append('grado_escolaridad',this.formulario.grado_escolaridad)

            /*Fomulario contratro*/
            formData.append('empleador_id',this.contrato.empleador_id)
            formData.append('fecha_ingreso',this.contrato.fecha_ingreso)
            formData.append('fecha_antiguidad',this.contrato.fecha_antiguidad)
            formData.append('fecha_vencimiento_contrato',this.contrato.fecha_vencimiento_contrato)
            formData.append('fecha_vencimiento_contrato_segundo',this.contrato.fecha_vencimiento_contrato_segundo)
            formData.append('ubicacion_id',this.contrato.ubicacion_id)
           // formData.append('prevision_id',this.contrato.prevision_id)
            //formData.append('salud_id',this.contrato.salud_id)
            formData.append('area_id',this.contrato.area_id)
            formData.append('centro_costo',this.contrato.centro_costo)
            formData.append('tipo_jornada',this.contrato.tipo_jornada)
            formData.append('jornada_excepcional',this.contrato.jornada_excepcional)
            formData.append('cargo_id',this.contrato.cargo_id)
            formData.append('tipo_contrato',this.contrato.tipo_contrato)
            formData.append('sueldo_base',this.sueldo_base)

            /* Formulario Prevision */
            formData.append('tipo_prevision',this.prevision.tipo_prevision)
            formData.append('prevision_id',this.prevision.prevision_id)
            formData.append('inp_id',this.prevision.inp_id)

            /*Formulario de salud*/
            formData.append('salud_id',this.salud.salud_id)
            formData.append('cotiza_siete_porciento',this.salud.cotiza_siete_porciento)
            formData.append('tipo_plan_salud',this.salud.tipo_plan_salud)
            formData.append('monto_peso',this.salud.monto_peso)
            formData.append('monto_uf',this.salud.monto_uf)

            /*Formulario de prevision ahorro voluntario*/
            let ahorros = []
            ahorros.push(this.ahorros)
            let ahorro_count = this.ahorros.length;
            //console.log(ahorro_count)
            formData.append('prevision_ahorro',JSON.stringify(ahorros))

            let contactos = []
            contactos.push(this.contacto)
            formData.append('contacto',JSON.stringify(contactos))

            let bancostraba = []
            bancostraba.push(this.bancotrabajadores)
            formData.append('bancosTrabajador',JSON.stringify(bancostraba))

            if(this.formulario.tiene_familia)
            {
                let familiar = []
                familiar.push(this.cargasFamiliares)
                formData.append('cargaFamiliar',JSON.stringify(familiar))
            }

            if (this.licencia_conducir)
            {
                let licencia = []
                licencia.push(this.licencia)
                formData.append('licencia',JSON.stringify(licencia))
            }

            /* si posee discapacidad*/
            formData.append('posee_carnet',this.salud_discapacidad.posee_carnet)
            formData.append('discapacidad',this.salud_discapacidad.discpacidad)
            formData.append('causa_principal',this.salud_discapacidad.causa_principal)
            formData.append('causa_secundaria',this.salud_discapacidad.causa_secundaria)
            formData.append('capacidad_reducidad',this.salud_discapacidad.capacidad_reducidad)
            /* si posee alguna enfermedad prexistente */
            formData.append('enfermedad_prexistente',this.salud_enfemedades.enfermedad_prexistente)
            formData.append('tipo_sangre',this.salud_enfemedades.tipo_sangre)
            formData.append('enfermedades',this.salud_enfemedades.enfermedades)
            formData.append('medicamentos',this.salud_enfemedades.medicamentos)

           // console.log(formData)
            if(this.editar){
                //console.log('por aqui pase')
                this.enviarEditarFormulario()
            }else {
             await  axios.post('/trabajadores',
                    formData,{
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then((response) => {
                    // this.respuesta = true
                    // this.alerta= 'alert-success'
                    // this.mensajes = 'Trabajador Creado exitosamente'
                 this.$swal.fire({
                        title: 'Trabajador Creado exitosamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#3085d6',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        stopKeydownPropagation: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '/trabajadores'
                        }
                    })


                }).catch( (error) => {
                    this.respuesta = true
                    this.alerta= 'alert-danger'
                    this.mensajes = 'Error al enviar el formulario'
                    this.errorsClass = 'form-control is-invalid';
                    this.$swal.fire({
                        title: 'Error al enviar el formulario',
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#3085d6',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        stopKeydownPropagation: false,
                    })
                    if (error.response.status === 422) {
                        this.mostarError = true
                        this.errors = error.response.data.errors || {};
                    }
                })
            }


        },
      async enviarEditarFormulario()
        {
            let id =  this.id
            let formData = new FormData();
            /* ficha trabajador */
            /* ficha trabajador */
            formData.append('rut',this.formulario.rut)
            formData.append('primer_nombre',this.formulario.primer_nombre)
            formData.append('segundo_nombre',this.formulario.segundo_nombre)
            formData.append('primer_apellido',this.formulario.primer_apellido)
            formData.append('segundo_apellido',this.formulario.segundo_apellido)
            formData.append('fecha_nac',this.formulario.fecha_nac)
            formData.append('estado_civil',this.formulario.estado_civil)
            formData.append('sexo',this.formulario.sexo)
            formData.append('telefono_celular',this.formulario.telefono_obligatorio)
            formData.append('telefono_local',this.formulario.telefono_opcional)
            formData.append('correo',this.formulario.correo)
            formData.append('confirmar_correo',this.formulario.confirmar_correo)
            formData.append('direccion',this.formulario.direccion)
            formData.append('region_id',this.formulario.region_id)
            formData.append('comuna_id',this.formulario.comuna_id)
            formData.append('nacionalidad',this.formulario.nacionalidad)
            formData.append('carga_familiar',this.formulario.tiene_familia)/* carga familiar */
            formData.append('pertenece_pueblo_originario',this.formulario.perteneces_pueblo_originario)
            formData.append('pueblo_originario_id',this.formulario.pueblo_originario_id)
            formData.append('tiene_alguna_discapacidad',this.formulario.tiene_discapacidad)
            formData.append('grado_escolaridad',this.formulario.grado_escolaridad)

            /*Fomulario contratro*/
            formData.append('empleador_id',this.contrato.empleador_id)
            formData.append('fecha_ingreso',this.contrato.fecha_ingreso)
            formData.append('fecha_antiguidad',this.contrato.fecha_antiguidad)
            formData.append('fecha_vencimiento_contrato',this.contrato.fecha_vencimiento_contrato)
            formData.append('fecha_vencimiento_contrato_segundo',this.contrato.fecha_vencimiento_contrato_segundo)
            formData.append('ubicacion_id',this.contrato.ubicacion_id)
            // formData.append('prevision_id',this.contrato.prevision_id)
            //formData.append('salud_id',this.contrato.salud_id)
            formData.append('area_id',this.contrato.area_id)
            formData.append('centro_costo',this.contrato.centro_costo)
            formData.append('tipo_jornada',this.contrato.tipo_jornada)
            formData.append('jornada_excepcional',this.contrato.jornada_excepcional)
            formData.append('cargo_id',this.contrato.cargo_id)
            formData.append('tipo_contrato',this.contrato.tipo_contrato)

            /* Formulario Prevision */
            formData.append('tipo_prevision',this.prevision.tipo_prevision)
            formData.append('prevision_id',this.prevision.prevision_id)
            formData.append('inp_id',this.prevision.inp_id)

            /*Formulario de salud*/
            formData.append('salud_id',this.salud.salud_id)
            formData.append('cotiza_siete_porciento',this.salud.cotiza_siete_porciento)
            formData.append('tipo_plan_salud',this.salud.tipo_plan_salud)
            formData.append('monto_peso',this.salud.monto_peso)
            formData.append('monto_uf',this.salud.monto_uf)

            /*Formulario de prevision ahorro voluntario*/
            let ahorros = []
            ahorros.push(this.ahorros)
            formData.append('prevision_ahorro',JSON.stringify(ahorros))

            let contactos = []
            contactos.push(this.contacto)
            formData.append('contacto',JSON.stringify(contactos))

            let bancostraba = []
            bancostraba.push(this.bancotrabajadores)
            formData.append('bancosTrabajador',JSON.stringify(bancostraba))

            if(this.formulario.tiene_familia)
            {
                let familiar = []
                familiar.push(this.cargasFamiliares)
                formData.append('cargaFamiliar',JSON.stringify(familiar))
            }


            if (this.licencia_conducir)
            {
                let licencia = []
                licencia.push(this.licencia)
                formData.append('licencia',JSON.stringify(licencia))

            }
            /* si posee discapacidad*/
            formData.append('posee_carnet',this.salud_discapacidad.posee_carnet ? 'Y':'N')
            formData.append('discapacidad',this.salud_discapacidad.discpacidad)
            formData.append('causa_principal',this.salud_discapacidad.causa_principal)
            formData.append('causa_secundaria',this.salud_discapacidad.causa_secundaria)
            formData.append('capacidad_reducidad',this.salud_discapacidad.capacidad_reducidad)
            /* si posee alguna enfermedad prexistente */
            formData.append('enfermedad_prexistente',this.salud_enfemedades.enfermedad_prexistente)
            formData.append('tipo_sangre',this.salud_enfemedades.tipo_sangre)
            formData.append('enfermedades',this.salud_enfemedades.enfermedades)
            formData.append('medicamentos',this.salud_enfemedades.medicamentos)
            //formData.append("_method", "put")
            //console.log(this.formulario.rut)
            this.respuesta = false
            //console.log(formData);
           await axios.post('/trabajadores/update_admin/'+id,
               formData,{
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then((res)=>{

               // console.log('por aQUI PASE' +
                   // this.alerta)

               /* this.respuesta = true
                this.alerta= 'alert-success'
                this.mensajes = 'Trabajador Editado exitosamente'*/
                // form.respuesta = response.data.mensaje;
                //event.target.reset();
               // this.reset_contacto()
               this.$swal.fire({
                   title: 'Trabajador Editado exitosamente',
                   icon: 'success',
                   confirmButtonText: 'Aceptar',
                   confirmButtonColor: '#3085d6',
                   allowOutsideClick: false,
                   allowEscapeKey: false,
                   allowEnterKey: false,
                   stopKeydownPropagation: false,
               }).then((result) => {
                   if (result.isConfirmed) {
                       window.location.href = '/trabajadores'
                   }
               })
            }).catch((error)=>{
              console.log(error)
               this.respuesta = true
               this.alerta= 'alert-danger'
               this.mensajes = 'Error al enviar el formulario'
               this.errorsClass = 'form-control is-invalid';
               this.$swal.fire({
                   title: 'Error al enviar el formulario',
                   icon: 'error',
                   confirmButtonText: 'Aceptar',
                   confirmButtonColor: '#3085d6',
                   allowOutsideClick: false,
                   allowEscapeKey: false,
                   allowEnterKey: false,
                   stopKeydownPropagation: false,
               })

               if (error.response.status === 422) {
                   this.mostarError = true
                   this.errors = error.response.data.errors || {};
               }
            })



        },
        editarFicha:function (){
            let editar = this.editar
           // this.cargarCities()
            if(editar){
                this.editarTrabajador = !this.editarTrabajador
            }
        }


    },
}
$(document).ready(function(){
    $(".nav-tabs a").click(function(){
        $(this).tab('show');
    });
    $('.nav-tabs a').on('shown.bs.tab', function(event){
        var x = $(event.target).text();         // active tab
        var y = $(event.relatedTarget).text();  // previous tab
        /*$(".act span").text(x);
        $(".prev span").text(y);*/
    });
});

</script>

<style scoped>

</style>
