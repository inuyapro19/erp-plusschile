<template>
    <div class="col-lg-11 mx-auto">
        <div class="row">
            <div class="col-md-6">
                <label for="tipo_prevision">Tipo de Entidad</label>
                <select name="tipo_prevision" id="tipo_prevision" class="form-control" v-model="prevision.tipo_prevision" @change="entidadSelected" :disabled="editarTrabajador"  >
                    <option value="">-----------</option>
                    <option value="afp">AFP</option>
                    <option value="inp">INP</option>
                </select>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="prevision_id">AFP</label>
                    <select name="prevision_id" v-model="prevision.prevision_id" :class="errors.prevision_id !== undefined ? errorsClass : inputClass" id="prevision_id" :disabled="editarTrabajador" >
                        <option value="">----------</option>
                        <option v-for="(previsiones, index) in prevision_afp" :value="previsiones.id">{{previsiones.nombre_prevision}}</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6" v-show="isInp">
                <div class="form-group">
                    <label for="prevision_inp_id">Inp</label>
                    <select name="prevision_inp_id" v-model="prevision.prevision_inp_id" :class="errors.prevision_inp_id !== undefined ? errorsClass : inputClass" id="prevision_inp_id" :disabled="editarTrabajador" >
                        <option value="">----------</option>
                        <option v-for="(inp, index) in prevision_inp" :value="inp.id">{{inp.nombre}}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapState,mapActions} from "vuex";

export default {
    props:{
        errors: Array,
        inputClass:String,
        errorsClass:String,
        editarTrabajador:Boolean
    },
    computed:{
        ...mapState('prevision',['prevision','isInp','isAfp'])
    },
    data() {
        return {
            prevision_afp:[],
            prevision_inp:[]
        }
    },
    mounted() {
        this.cargarPrevicion();
        this.cargarPrevicionInp();
    },
    methods:{
        ...mapActions('prevision',['esInp','esAfp']),
        cargarPrevicion:function (){
            axios.get('/prevision').then(res=>{
                this.prevision_afp = res.data
            })
        },
        cargarPrevicionInp:function (){
            axios.get('/prevision_inp').then(res=>{
                this.prevision_inp = res.data
            })
        },
        entidadSelected:function (){
            let tipo_prevision = this.prevision.tipo_prevision

            if (tipo_prevision==='inp'){
                this.esInp()
            }else{
                this.esAfp()
            }

        }
    }
}
</script>

<style scoped>

</style>
