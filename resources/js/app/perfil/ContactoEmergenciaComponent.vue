<template>
    <div>
        <div class="col-xl-12 col-lg-12 col-md-12 mt-4 pl-5 pr-5 layout-spacing section contact" >

            <div class="info">
                <h5 class="">Contacto de Emergencia #1</h5>
                <div class="row">
                    <div class="col-md-11 mx-auto">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" id="nombre" v-model="primer_nombre_contacto" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="apellido">Apellido</label>
                                    <input type="text" id="apellido" class="form-control" v-model="primer_apellido_contacto">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="telefono">Télefono</label>
                                    <input type="text" class="form-control" v-model="primer_telefono_contacto" id="telefono">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="correo">Correo</label>
                                    <input type="email" class="form-control" v-model="primer_email_contacto" id="correo">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="direccion">Dirección</label>
                                    <input type="text" class="form-control" id="direccion" v-model="primer_direccion_contacto">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="region">Región</label>
                                    <select name="region" id="region" v-model="primer_region_id" class="form-control" @change.prevent="cargarCities()">
                                        <option value="">----Seleccion Región--</option>
                                        <option v-for="(region, index) in regiones " :value="region.id">{{region.nombre_region}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="comuna">comuna</label>
                                    <select name="region" id="comuna" class="form-control" v-model="primer_comuna_id">
                                        <option value="">----Seleccion Comuna--</option>
                                        <option v-for="(comuna, index) in comunas " :value="comuna.id">{{comuna.nombre_comuna}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="comuna">Parentesco</label>
                                    <select name="region" id="parentesco" v-model="primer_parentesco_contacto" class="form-control" @change.prevent="OtroParentesco">
                                        <option value="">----Seleccion Parentesco--</option>
                                        <option v-for="(parentesco, index) in parentescos " :value="parentesco">{{parentesco}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <transition name="slide-fade">
                                    <div class="form-group" v-show="otro_parentesco_primer">
                                        <label for="otro_parentesco">Otro Parentesco</label>
                                        <input type="text" class="form-control" v-model="primer_otro_parentesco_contacto" id="otro_parentesco" placeholder="Ingrese otro parentesco">

                                    </div>
                                </transition>
                            </div>
                            <div class="col-md-12">
                                <button type="button" class="btn btn-success btn-sm" @click.prevent="enviar_formulario(1)">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 mt-4 pl-5 pr-5 layout-spacing section contact" >

            <div class="info">
                <h5 class="">Contacto de Emergencia #2</h5>
                <div class="row">
                    <div class="col-md-11 mx-auto">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" id="nombre" v-model="segundo_nombre_contacto" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="apellido">Apellido</label>
                                    <input type="text" id="apellido" class="form-control" v-model="segundo_apellido_contacto">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="telefono">Télefono</label>
                                    <input type="text" class="form-control" v-model="segundo_telefono_contacto" id="telefono">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="correo">Correo</label>
                                    <input type="email" class="form-control" v-model="segundo_email_contacto" id="correo">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="direccion">Dirección</label>
                                    <input type="text" class="form-control" id="direccion" v-model="segundo_direccion_contacto">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="region">Región</label>
                                    <select name="region" id="region" v-model="segundo_region_id" class="form-control" @change.prevent="cargarCities()">
                                        <option value="">----Seleccion Región--</option>
                                        <option v-for="(region, index) in regiones " :value="region.id">{{region.nombre_region}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="comuna">comuna</label>
                                    <select name="region" id="comuna" class="form-control" v-model="segundo_comuna_id">
                                        <option value="">----Seleccion Comuna--</option>
                                        <option v-for="(comuna, index) in comunas_dos" :value="comuna.id">{{comuna.nombre_comuna}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="comuna">Parentesco</label>
                                    <select name="region" id="parentesco" v-model="segundo_parentesco_contacto" class="form-control" @change.prevent="OtroParentesco">
                                        <option value="">----Seleccion Parentesco--</option>
                                        <option v-for="(parentesco, index) in parentescos " :value="parentesco">{{parentesco}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <transition name="slide-fade">
                                    <div class="form-group" v-show="otro_parentesco_segundo">
                                        <label for="otro_parentesco">Otro Parentesco</label>
                                        <input type="text" class="form-control" v-model="segundo_otro_parentesco_contacto" id="otro_parentesco" placeholder="Ingrese otro parentesco">

                                    </div>
                                </transition>
                            </div>

                            <div class="col-md-12">
                                <button class="btn btn-success btn-sm" type="button"  @click.prevent="enviar_formulario(2)">Guardar</button>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>

import {mapState} from "vuex";

export default {
   props:{
       contacto1:Object,
       rut:String
   },
    computed:{
       ...mapState('contacto',['perfilContacto'])
    },
    data() {
        return {
            regiones: [],
            comunas:[],
            comunas_dos:[],
            comunas_all:[],
            parentescos:[
                'hijo(a)',
                'padre',
                'conyuge',
                'madre',
                'abuelo(a)',
                'otro'
            ],
            otro_parentesco_primer:false,
            otro_parentesco_segundo:false,
            primer_contacto_id:'',
            primer_nombre_contacto:'',
            primer_apellido_contacto:'',
            primer_telefono_contacto:'',
            primer_email_contacto:'',
            primer_direccion_contacto:'',
            primer_parentesco_contacto:'',
            primer_otro_parentesco_contacto:'',
            primer_region_id:0,
            primer_comuna_id:0,
            segundo_contacto_id:0,
            segundo_nombre_contacto:'',
            segundo_apellido_contacto:'',
            segundo_telefono_contacto:'',
            segundo_email_contacto:'',
            segundo_direccion_contacto:'',
            segundo_parentesco_contacto:'',
            segundo_otro_parentesco_contacto:'',
            segundo_region_id:0,
            segundo_comuna_id:0
        }
    },
    mounted() {
        this.cargarState()
        this.cargarCitiesAll()
        this.get_fisrt_contacto()
        this.get_second_contacto()
    },
    methods:{
        cargarState:function(){
            axios.get('/regiones').then(res=>{
                this.regiones = res.data
            })
        },
        cargarCities:function(id){

            if(this.primer_region_id > 0){
                this.comunas = this.comunas_all.filter((item) => item.region_id === this.primer_region_id )
            }

            if(this.segundo_region_id > 0){
                this.comunas_dos = this.comunas_all.filter((item) => item.region_id === this.segundo_region_id )
            }

        },
        cargarCitiesAll:function (){
            axios.get('/comunas').then(res=>{
                this.comunas = res.data
                this.comunas_dos = res.data
                this.comunas_all = res.data
            })
        },
        OtroParentesco:function (){
            //let parentesco = this.primer_parentesco_contacto
            //console.log(this.contactoForm.parentesco)
            if (this.primer_parentesco_contacto=== 'otro'){
                this.otro_parentesco_primer = true
            }else{
                this.otro_parentesco_primer = false
            }

            if (this.segundo_parentesco_contacto=== 'otro'){
                this.otro_parentesco_segundo = true
            }else{
                this.otro_parentesco_segundo = false
            }
        },
        async get_fisrt_contacto(){
            await axios.get('/getPerfilPrimerContacto').then(res=>{
                    this.primer_contacto_id = res.data.id > 0 ? res.data.id : 0
                    this.primer_nombre_contacto = res.data.nombre
                    this.primer_apellido_contacto = res.data.apellido
                    this.primer_telefono_contacto = res.data.telefono
                    this.primer_email_contacto = res.data.correo
                    this.primer_direccion_contacto = res.data.direccion
                    this.primer_parentesco_contacto = res.data.parentesco
                    this.primer_otro_parentesco_contacto = res.data.otro_parentesco
                    this.primer_region_id = res.data.region_id
                    this.primer_comuna_id = res.data.comuna_id
            }).catch(error=>{
                console.log(error)
            })
        },
        async get_second_contacto(){
            await axios.get('/getPerfilSegundoContacto').then(res=>{
                this.segundo_contacto_id = res.data.id > 0 ? res.data.id : 0
                this.segundo_nombre_contacto = res.data.nombre
                this.segundo_apellido_contacto = res.data.apellido
                this.segundo_telefono_contacto = res.data.telefono
                this.segundo_email_contacto = res.data.correo
                this.segundo_direccion_contacto = res.data.direccion
                this.segundo_parentesco_contacto = res.data.parentesco
                this.segundo_otro_parentesco_contacto = res.data.otro_parentesco
                this.segundo_region_id = res.data.region_id
                this.segundo_comuna_id = res.data.comuna_id
            }).catch(error=>{
                console.log(error)
            })
        },
        async enviar_formulario(numero){
            let formData = new FormData

            if (numero === 1 ){


                formData.append('nombre',this.primer_nombre_contacto)
                formData.append('apellido',this.primer_apellido_contacto)
                formData.append('telefono',this.primer_telefono_contacto)
                formData.append('email',this.primer_email_contacto)
                formData.append('direccion',this.primer_direccion_contacto)
                formData.append('id',this.primer_contacto_id)
                formData.append('region_id',this.primer_region_id)
                formData.append('comuna_id',this.primer_comuna_id)
                formData.append('parentesco',this.primer_parentesco_contacto)
                formData.append('otro_parentesco',this.primer_otro_parentesco_contacto)
            }
            if (numero === 2 ){

                formData.append('nombre',this.segundo_nombre_contacto)
                formData.append('apellido',this.segundo_apellido_contacto)
                formData.append('telefono',this.segundo_telefono_contacto)
                formData.append('email',this.segundo_email_contacto)
                formData.append('direccion',this.segundo_direccion_contacto)
                formData.append('id',this.segundo_contacto_id)
                formData.append('region_id',this.segundo_region_id)
                formData.append('comuna_id',this.segundo_comuna_id)
                formData.append('parentesco',this.segundo_parentesco_contacto)
                formData.append('otro_parentesco',this.segundo_otro_parentesco_contacto)
            }
            axios.post('/perfil/'+rut,formData).then(res =>{
                this.$swal('Contacto guardado correctamente')
            }).catch(error=>{
                console.log(error)
                this.$swal('error al enviar formulario')
            })

        }
    }
}
</script>

<style scoped>

</style>
