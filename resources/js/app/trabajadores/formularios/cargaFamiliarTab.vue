<template>
        <div class="row">
            <div class="col-md-12">
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
        </div>
</template>

<script>
import {mapActions, mapState} from "vuex";
import {required} from "vuelidate/lib/validators";
import {validate} from "rut.js";
const moment = require('moment');
export default {
    props:{
        parentesco:Object,
    },
    computed:{
        ...mapState('cargaFamiliar',['cargaFamiliar','cargasFamiliares']),
    },
    data() {
        return {
            codigoParentescos:[],
            familiar:[],
            alert_success:'alert-success',
            alert_danger:'alert-danger',
            success:false,
            danger:false,
        }
    },
    mounted() {
        this.cargarParentesco()
    },
    methods:{
        ...mapActions('cargaFamiliar',['addCargaFamiliar','deleteCargaFamiliar','generateID','obtenerCargaFamiliar']),
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

    }
}
</script>

<style scoped>

</style>
