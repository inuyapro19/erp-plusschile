<template>
    <div class="col-lg-11 mx-auto">

        <div class="row">
            <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                <div :class="'alert '+alert_success" v-show="success">Banco agregado exitosamente</div>
                <div :class="'alert '+alert_danger" v-show="danger">Debe rellenar todos los campos</div>
                <div class="form">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Banco</label>
                                <select v-model="$v.bancotrabajador.$model.banco_id" @change="filtrabanco" :class="$v.bancotrabajador.banco_id.$error ? 'form-control mt-4 is-invalid':'form-control'" :disabled="editarTrabajador"  >
                                    <option value="0">Selecciones Banco</option>
                                    <option v-for="(banco , index) in bancos" :value="banco.id" >{{banco.nombre_banco}}</option>
                                </select>
                                <input type="hidden" v-model="bancotrabajador.nombre_banco">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div  class="form-group">
                                <label>Nro cuenta</label>
                                <input type="text" v-model="$v.bancotrabajador.$model.nro_cuenta" :disabled="editarTrabajador" name="nro_cuenta" :class="$v.bancotrabajador.nro_cuenta.$error ? 'form-control solo_numero is-invalid':'form-control solo_numero'">
                                <div class="error" v-show="$v.bancotrabajador.nro_cuenta.$error">Nro cuenta es requerido</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tipo Cuenta</label>
                                <select v-model="$v.bancotrabajador.$model.tipo_cuenta" name="tipo_cuenta" :disabled="editarTrabajador" :class="$v.bancotrabajador.tipo_cuenta.$error ? 'form-control is-invalid':'form-control'">
                                    <option value="0">--------</option>
                                    <option value="cuenta corriente">Cuenta Corriente</option>
                                    <option value="cuenta vista">Cuenta Vista</option>
                                    <option value="chequera electronica">Chequera Electronica</option>
                                    <option value="cuenta de ahorro">cuenta de ahorro</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div  class="form-group">
                                <label>Fecha Ingreso</label>
                                <input type="date" v-model="$v.bancotrabajador.$model.fecha_ingreso_cuenta" :disabled="editarTrabajador" name="nro_cuenta" :class="$v.bancotrabajador.fecha_ingreso_cuenta.$error ? 'form-control is-invalid':'form-control'">
                                <div class="error" v-show="$v.bancotrabajador.fecha_ingreso_cuenta.$error">Nro cuenta es requerido</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <label for="predeterminado" class="form-check-label">Predeterminado</label>
                        </div>
                        <div class="col-md-3">

                            <label class="switch s-icons s-outline s-outline-success  mr-2">
                                <input type="checkbox" id="predeterminado" v-model="bancotrabajador.predeterminado"   :disabled="editarTrabajador"  @change.prevent="licencia()" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="col-md-4">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" v-show="mostraragregarContacto">
                            <button type="button" class="btn btn-secondary btn-sm" @click.prevent="agregarBanco()" :disabled="editarTrabajador"> <i class="fa fa-plus"></i> Agregar</button>
                        </div>
                        <div class="col-md-12" v-show="mostareditarContacto">
                            <button type="button" class="btn btn-secondary btn-sm" @click.prevent="EditarBanco()" :disabled="editarTrabajador"> <i class="fa fa-plus"></i> Editar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <th>Nro Cuenta</th>
                        <th>Tipo de cuenta</th>
                        <th>Banco</th>
                        <th>Fecha Ingreso Cuenta</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        <tr v-for="(banco, index) in bancotrabajadores">
                            <td>{{banco.nro_cuenta}}</td>
                            <td>{{banco.tipo_cuenta}}</td>
                            <td>{{banco.nombre_banco ? banco.nombre_banco : banco.banco.nombre_banco}}</td>
                            <td>{{banco.fecha_ingreso_cuenta | moment("DD-MM-YYYY")}}</td>
                            <td>
                                <button type="button" :class="banco.predeterminado === 'Y' ? 'btn btn-success btn-sm':'btn btn-default btn-sm'"  title="Predeterminado"><i class="fa fa-star"></i></button>
                                <button type="button" class="btn btn-sm btn-danger" @click.prevent="deleteBanco(banco.id)" title="Eliminar"><i class="fa fa-trash"></i></button>
                                <button type="button" class="btn btn-sm btn-info" @click.prevent="obtenerBanco(banco.id)" title="Editar"><i class="fa fa-edit"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import { Validator } from 'vee-validate';
import {mapActions, mapState} from "vuex";
const shortid = require('shortid');
import { required } from 'vuelidate/lib/validators';

export default {
    props:{
        editarTrabajador:Boolean
    },
    data() {
        return {
            bancos: [],
            boton_color:'btn btn-sm btn-default',
            alert_success:'alert-success',
            alert_danger:'alert-danger',
            success:false,
            danger:false,
            banco_seleccionado:''
        }
    },
    validations: {
        bancotrabajador:{
            banco_id:{
                required,
            },
            nro_cuenta:{
                required
            },
            tipo_cuenta:{
                required
            },
            fecha_ingreso_cuenta:{
                required
            }
        }
    },
    computed:{
      ...mapState('bancos',['bancotrabajadores','bancotrabajador','mostraragregarContacto','mostareditarContacto'])
    },
    mounted() {
       this.cargarBancos()
    },
    watch: {
        bancotrabajador: {
            banco_id:function (value) {
                console.log(value);
            }
        }
    },
    methods:{
        ...mapActions('bancos',['addBancos','deleteBanco','obtenerBanco','generateID','fitrarBanco','setNombreBanco','updateBancos']),
        cargarBancos:function ()
        {
            axios.get('/bancos').then(res=>{
                this.bancos = res.data
            })
        },
        EditarBanco:function ()
        {
            console.log(this.$v)
         this.$v.$touch()

            if (this.$v.$invalid) {
                this.danger = true
                console.log('error en el envio de formulario')
            }else{
                this.success = true
                this.danger = false
                //let id = shortid.generate()
                //this.generateID(id)
                //console.log(this.bancosTrabajador.id)
                //this.bancoTrabajador.push(this.BancoTrabajadores)
                this.updateBancos(this.bancotrabajador)
               /* let banco_name = []
                banco_name = this.bancos.find(items => this.bancos.id === this.bancotrabajador.banco_id )*/

            }
        },
        agregarBanco:function ()
        {
            console.log(this.$v)
            this.$v.$touch()

            if (this.$v.$invalid) {
                this.danger = true
                console.log('error en el envio de formulario')
            }else{
                this.success = true
                this.danger = false
                let id = shortid.generate()
                this.generateID(id)
                //console.log(this.bancosTrabajador.id)
                //this.bancoTrabajador.push(this.BancoTrabajadores)
                this.addBancos()
                /* let banco_name = []
                 banco_name = this.bancos.find(items => this.bancos.id === this.bancotrabajador.banco_id )*/

            }
        },
        filtrabanco:function ()
        {
           console.log(this.bancotrabajador.banco_id)
           let nombre_banco = []
            nombre_banco = this.bancos.find(items => items.id === this.bancotrabajador.banco_id)
            console.log(nombre_banco.nombre_banco)
            let banco = nombre_banco.nombre_banco
            this.setNombreBanco(banco)
        },
        filtrarKey:function(e)
        {
            // Si el código es menor que 48 (0) o mayor que 57 (9)
            if(e.keyCode < 48 || e.keyCode > 57) {
                // No se agrega
                e.preventDefault();
            }
        },
        chequearKey:function (item){
            // Obtener valor actual
            let valor = parseInt(item.value);
            // Si no es número o es menor de 1
            if(isNaN(valor) || valor < 1) {
                // Asignar 1
                item.value = 1;
            }
        },


    }
}

$(function(){
    $(".solo_numero").keydown(function(event){
        //alert(event.keyCode);
        if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105) && event.keyCode !==190  && event.keyCode !==110 && event.keyCode !==8 && event.keyCode !==9  ){
            return false;
        }
    });
});

</script>
<style scoped>
        .error{
            color: #de1a1a;
        }
</style>
