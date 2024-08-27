<template>
    <div>
        <div class="col-md-11 mx-auto">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" v-model="contacto2.nombre" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" id="apellido" class="form-control" v-model="contacto2.apellido">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="telefono">Télefono</label>
                        <input type="text" class="form-control" v-model="contacto2.telefono" id="telefono">
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="correo">Correo</label>
                        <input type="email" class="form-control" v-model="contacto2.correo" id="correo">
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" class="form-control" id="direccion" v-model="contacto2.direccion">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="region">Región</label>
                        <select name="region" id="region" v-model="contacto2.region_id" class="form-control" @change.prevent="cargarCities">
                            <option value="">----Seleccion Región--</option>
                            <option v-for="(region, index) in regiones " :value="region.id">{{region.nombre_region}}</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="comuna">comuna</label>
                        <select name="region" id="comuna" class="form-control" v-model="contacto2.comuna_id">
                            <option value="">----Seleccion Comuna--</option>
                            <option v-for="(comuna, index) in comunas " :value="comuna.id">{{comuna.nombre_comuna}}</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="comuna">Parentesco</label>
                        <select name="region" id="parentesco" v-model="contacto2.parentesco" class="form-control" @change.prevent="OtroParentesco()">
                            <option value="">----Seleccion Parentesco--</option>
                            <option v-for="(parentesco, index) in parentescos " :value="parentesco">{{parentesco}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <transition name="slide-fade">
                        <div class="form-group" v-show="otro_parentesco">
                            <label for="otro_parentesco">Otro Parentesco</label>
                            <input type="text" class="form-control" v-model="contacto2.otro_parentesco" id="otro_parentesco" placeholder="Ingrese otro parentesco">

                        </div>
                    </transition>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

import {mapState} from "vuex";

export default {
    props:{
        contacto2:Object,
    },
    computed:{
        ...mapState('contacto',['perfilContacto'])
    },
    data() {
        return {
            regiones: [],
            comunas:[],
            parentescos:[
                'hijo(a)',
                'padre',
                'conyuge',
                'madre',
                'abuelo(a)',
                'otro'
            ],
            otro_parentesco:false,

        }
    },
    mounted() {
        this.cargarState()
    },
    methods:{
        cargarState:function(){
            axios.get('/regiones').then(res=>{
                this.regiones = res.data
            })
        },
        cargarCities:function(){
            let id = this.contacto2.region_id

            axios.get('/comunas/'+id).then(res=>{
                this.contacto2.comuda_id = '0'
                this.comunas = res.data
            })
        },
        OtroParentesco:function (){
            let parentesco = this.contacto2.parentesco
            //console.log(this.contactoForm.parentesco)
            if (parentesco=== 'otro'){
                this.otro_parentesco = true
            }else{
                this.otro_parentesco = false
            }
        }
    }
}
</script>

<style scoped>

</style>
