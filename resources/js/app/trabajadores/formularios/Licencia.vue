<template>
    <div class="col-lg-11 mx-auto">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Nro serie</label>
                    <input type="text" class="form-control" v-model="licencia.nro_serie" :disabled="editarTrabajador">

                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Fecha Ingreso</label>
                    <input type="date" class="form-control" v-model="licencia.fecha_de_ingreso" :disabled="editarTrabajador">

                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Fecha Vencimiento</label>
                    <input type="date" class="form-control" v-model="licencia.fecha_de_vencimiento" :disabled="editarTrabajador">

                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Categoria de Licencia</label>
                    <select class="form-control mb-4 selectpicker" v-model="licencia.categorias" ref="categorias" multiple data-live-search="false" :disabled="editarTrabajador" >
                        <option v-for="(tipo_licencias, index) in tipo_licencia" :value="tipo_licencias.id" >{{tipo_licencias.descripcion}}</option>
                    </select>

                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                    <label>Restricciones</label>
                    <textarea v-model="licencia.restriccion" class="form-control" id="" cols="30" rows="10" :disabled="editarTrabajador"></textarea>

                </div>
            </div>

        </div>

      <!--  <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-secondary btn-sm" @click.prevent="agregarLicencia()"> <i class="fa fa-plus"></i> Agregar</button>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <th>Nro serie</th>
                    <th>Fecha ingreso</th>
                    <th>Fecha Vencimiento</th>
                    <th>Tipo licencia</th>
                    <th>Acciones</th>
                    </thead>
                    <tbody>
                    <tr v-for="(conducir, index) in licencias">
                        <td>{{conducir.nro_serie}}</td>
                        <td>{{conducir.fecha_de_ingreso}}</td>
                        <td>{{conducir.fecha_de_vencimiento}}</td>
                        <td>{{conducir.tipo_licencia}}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger" @click.prevent="deleteLicencia(conducir.id)" title="Eliminar"><i class="fa fa-trash"></i></button>
                            <button type="button" class="btn btn-sm btn-info" @click.prevent="obtenerLicencia(conducir.id)" title="Editar"><i class="fa fa-edit"></i></button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>-->

    </div>
</template>

<script>

import {mapActions, mapState} from "vuex";
const shortid = require('shortid');
export default {
    props:{
        editarTrabajador:Boolean
    },
    data() {
        return {
            tipo_licencia: [],
            error:[],
        }
    },
    computed:{
        ...mapState('licencia',['licencias','licencia'])
    },

    mounted() {
        this.cargarTipoLicencia()
    },
    updated() {
        this.refrescar()
        },
    methods:{
        ...mapActions('licencia',['addLicencia','generateID','deleteLicencia','obtenerLicencia']),
        refrescar:function(){
           //this.$refs.categorias.selectpicker('refresh')
            $(this.$refs.categorias).selectpicker('refresh')
        },
        cargarTipoLicencia:function (){
            axios.get('/tipo_licencia').then(res=>{
                this.tipo_licencia = res.data
            })
        },
        agregarLicencia:function ()
        {
            let formData = new FormData();
            formData.append('tipo_licencia_id',this.licencia.tipo_licencia)
            formData.append('nro_serie',this.licencia.nro_serie)
            formData.append('fecha_de_vencimiento',this.licencia.fecha_de_vencimiento)
            formData.append('fecha_de_ingreso',this.licencia.fecha_de_ingreso)

            axios.post('/licencia_store', formData,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(res=>{
                let id = shortid.generate()
                this.generateID(id)
                this.addLicencia()
            })

        }
   }
}
</script>

<style scoped>

</style>
