<template>
    <div class="col-lg-11 mx-auto">
        <div class="row">
            <div class="col-md-6">
                <label for="salud_id">Entidad de Salud</label>
                <select name="salud_id" id="salud_id" v-model="salud.salud_id" class="form-control" :disabled="editarTrabajador"  >
                    <option value="">-----------</option>
                    <option v-for="(entidad, index) in entidad_salud" :value="entidad.id">{{entidad.nombre_salud}}</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="cotiza_siete_porciento">Cotiza el 7%</label>
                <select name="cotiza_siete_porciento" v-model="salud.cotiza_siete_porciento" @change="esSietePorciento" id="cotiza_siete_porciento" class="form-control" :disabled="editarTrabajador" >
                    <option value="">-----------</option>
                    <option value="si">Si</option>
                    <option value="no">No</option>
                </select>
            </div>
        </div>
        <div class="row mt-2" v-show="siete_porciento">
            <div class="col-md-6">
                <label for="tipo_plan_salud">Tipo de plan salud</label>
                <select name="tipo_plan_salud" v-model="salud.tipo_plan_salud" id="tipo_plan_salud" @change="habilitarMontoPesoUf" class="form-control" :disabled="editarTrabajador"   >
                    <option value="">-----------</option>
                    <option v-for="(plan, index) in tipo_plan_salud" :value="plan">{{plan}}</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="peso">Monto Peso</label>
                <input type="number" v-model="salud.monto_peso" :disabled="es_monto_peso" step=any class="form-control" id="peso">
            </div>
            <div class="col-md-3">
                <label for="uf">Monto UF</label>
                <input type="number" v-model="salud.monto_uf" :disabled="es_monto_uf" step=any class="form-control" id="uf">
            </div>
        </div>
    </div>
</template>

<script>
import {mapState,mapActions} from "vuex";


export default {
    props:{
        editarTrabajador:Boolean
    },
    computed:{
      ...mapState('Salud',['salud','tipo_plan_salud','es_monto_peso','es_monto_uf','siete_porciento']),
        isMontoPeso:function (){
          return this.es_monto_peso ? '':'disabled';
        },
        isMontoUF:function (){
            return this.es_monto_uf ? '':'disabled';
        }
    },
    data() {
        return {
            entidad_salud: [],
        }
    },
    mounted() {
     this.cargarSalud()
    },
    methods:{
        ...mapActions('Salud',['siente_porciento','habilitarMonto']),
        cargarSalud:function (){
            axios.get('/salud').then(res=>{
                this.entidad_salud = res.data
            })
        },
        esSietePorciento:function (){
            let siete_porciento = this.salud.cotiza_siete_porciento
            if(siete_porciento === 'si'){
                this.siente_porciento('si')
            }else{
                this.siente_porciento('no')
            }
        },
        habilitarMontoPesoUf:function (){
            let tipo_monto = this.salud.tipo_plan_salud
            console.log(tipo_monto)
            this.habilitarMonto(tipo_monto)
        }

    }
}
</script>

<style scoped>

</style>
