<template>
    <!-- Modal -->
   <div class="my-3 mx-3">
       <div :class="'alert '+alert_success" v-show="success">Carga familiar agregada exitosamente</div>
       <div :class="'alert '+alert_danger" v-show="danger">Debe rellenar todos los campos</div>
       <h3>Agregar Carga Familiar</h3>

       <div class="row">
           <div class="col-md-4">
               <div class="form-group">
                   <label class="text-left" for="carga_rut">RUT</label>
                   <input type="text" v-model="cargaFamiliar.rut" @blur="comprobar_rut" class="form-control  form-control-sm" id="carga_rut" :disabled="editarTrabajador">
               </div>
           </div>
           <div class="col-md-4">
               <div class="form-group">
                   <label for="nombres" class="text-left">Nombres</label>
                   <input type="text" v-model="cargaFamiliar.nombres" class="form-control  form-control-sm" id="nombres" :disabled="editarTrabajador">
               </div>
           </div>
           <div class="col-md-4">
               <div class="form-group">
                   <label for="apellidos" class="text-left">Apellidos</label>
                   <input type="text" v-model="cargaFamiliar.apellidos" class="form-control  form-control-sm" id="apellidos" :disabled="editarTrabajador">
               </div>
           </div>
       </div>
       <div class="row">
           <div class="col-md-4">
               <div class="form-group">
                   <label for="fecha_nac">Fecha Nacimiento</label>
                   <input type="date" v-model="cargaFamiliar.fecha_nacimiento" class="form-control  form-control-sm" id="fecha_nac" :disabled="editarTrabajador">
               </div>
           </div>
           <div class="col-md-4">
               <label for="codigo_parentesco">Código Parentesco</label>
               <select name="codigo_parentesco" v-model="cargaFamiliar.parentesco_id" class="form-control" id="codigo_parentesco" :disabled="editarTrabajador">
                   <option value="">-------------</option>
                   <option v-for="(codigo, index) in codigoParentescos" :value="codigo.id">{{codigo.descripcion}}</option>

               </select>
           </div>
         <!--  <div class="form-group col-md-4">
               <label for="file-upload">Certificado Nacimiento</label>
              <input  name="excel" ref="certificado_nac"  id="file-upload"  type="file" aria-label="Adjunte Certificado de nacimiento" @change="onFileChange()"    accept=".pdf" />

           </div>-->
       </div>

       <div class="row">


       </div>

       <div class="row mx-3 my-3">
           <div class="col-md-12" v-show="mostraragregarContacto">
               <button type="button" class="btn btn-secondary btn-sm float-right" @click.prevent="agregarFamiliar()" :disabled="editarTrabajador"><i class="fa fa-plus"></i> Agregar</button>
           </div>
           <div class="col-md-12" v-show="mostareditarContacto">
               <button type="button" class="btn btn-secondary btn-sm float-right" @click.prevent="editarFamiliar()" :disabled="editarTrabajador"><i class="fa fa-plus"></i> Editar</button>
           </div>
       </div>

       <div class="table-responsive mx-3 my-3">
           <table class="table table-striped">
               <thead>
               <th>Rut</th>
               <th>Nombre</th>
               <th>Apellido</th>
               <th>Fecha Nac.</th>
               <th>Fecha Termino</th>
               <th>Parentesco</th>
               <th>Acciones</th>
               </thead>
               <tbody>
               <tr v-for="(familiares, index) in cargasFamiliares">
                   <td>{{familiares.rut}}</td>
                   <td>{{familiares.nombres}}</td>
                   <td>{{familiares.apellidos}}</td>
                   <td>{{ familiares.fecha_nacimiento | moment("DD-MM-YYYY")}}</td>
                   <td>{{familiares.fecha_vencimiento_carga | moment("DD-MM-YYYY")}}</td>
                   <td>{{familiares.parentesco_id}}</td>
                   <td>
                       <button type="button" @click.prevent="deleteCargaFamiliar(familiares.id)" class="btn btn-danger btn-sm" title="eliminar"><i class="fa fa-trash"></i></button>
                       <button type="button" @click.prevent="obtenerCargaFamiliar(familiares.id)" class="btn btn-info btn-sm" title="editar"><i class="fa fa-edit"></i></button>
                   </td>
               </tr>
               </tbody>
           </table>
       </div>
   </div>




</template>

<script>
import {mapState,mapActions} from "vuex";
import {email, required} from "vuelidate/lib/validators";
const shortid = require('shortid');
import {  validate, clean, format, getCheckDigit } from 'rut.js'
export default {

    computed:{
      ...mapState('cargaFamiliar',['cargaFamiliar','cargasFamiliares','mostraragregarContacto','mostareditarContacto'])
    },
    data() {
        return {
            codigoParentescos:[],
            familiar:[],
            alert_success:'alert-success',
            alert_danger:'alert-danger',
            success:false,
            danger:false,
            parentesco:[],
            editarTrabajador:false,
            size:'',
            filename:'',
           archivo:''
        }
    },
    mounted() {
        this.cargarParentesco()
    },
    validations: {
        cargaFamiliar:{
            rut: {required},
            nombres:{required},
            apellidos:{required},
            fecha_nacimiento:{required},
            fecha_vencimiento_carga:{required},
            parentesco_id:{required},
        }
    },
    methods:{
        ...mapActions('cargaFamiliar',['addCargaFamiliar','deleteCargaFamiliar','generateID','obtenerCargaFamiliar','updateCargaFamiliar','Addcertificados']),
        agregarFamiliar:function ()
        {
           this.$v.$touch()
            if (this.$v.$invalid) {
                this.danger = true
                console.log('error en el envio de formulario')
            }else{
                this.success = true
                this.danger = false
                let id = shortid.generate()
                this.generateID(id)
                this.addCargaFamiliar()
                //this.Addcertificados(this.archivo)
           }

        },
        EditarFamiliar:function ()
        {
            this.$v.$touch()
            if (this.$v.$invalid) {
                this.danger = true
                console.log('error en el envio de formulario')
            }else{
                this.success = true
                this.danger = false
                //let id = shortid.generate()
                //this.generateID(id)
                this.updateCargaFamiliar(this.cargaFamiliar)
            }

        },
        cargarParentesco:function (){
            axios.get('/codigo_parentesco').then(res=>{
                this.codigoParentescos = res.data
            })
        },
        comprobar_rut:function ()
        {
            /* console.log(this.formulario.rut)
            this.rut_valido = validate_rut({exact: true, dot: true, hyphen: true}).test(this.formulario.rut)
             console.log(this.rut_valido)*/

            this.rut_valido = validate(this.cargaFamiliar.rut)
            this.cargaFamiliar.rut = format_sin_puntos(this.cargaFamiliar.rut)
            if(this.rut_valido){
                this.rut_errorneo=false
            }else{
                this.rut_errorneo = true
            }
        },
        onFileChange() {
            //console.log(e.target.files[0]);
            this.filename =   this.$refs.certificado_nac.files[0].name;
            this.size =  this.file = this.$refs.certificado_nac.files[0].size;
            this.archivo = this.$refs.certificado_nac.files[0];
        }
    }

}
function format_sin_puntos (rut) {
    rut = clean(rut)

    let result = rut.slice(-4, -1) + '-' + rut.substr(rut.length - 1)
    for (let i = 4; i < rut.length; i += 3) {
        result = rut.slice(-3 - i, -i)  + result
    }

    return result
}
</script>

