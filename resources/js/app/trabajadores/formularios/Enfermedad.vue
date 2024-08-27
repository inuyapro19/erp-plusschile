<template>
    <!-- Modal -->
    <div class="modal fade modal-notification" id="enfermedad" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" id="standardModalLabel">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Datos de salud</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row mt-3">
                        <div class="col-md-5">
                            <label for="posee_carnet_discapacidad" class="form-check-label">Posee carnet de discapacidad</label>
                        </div>
                        <div class="col-md-3">

                            <label class="switch s-icons s-outline s-outline-success  mr-2">
                                <input type="checkbox" id="posee_carnet_discapacidad" v-model="salud_discapacidad.posee_carnet" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    <div class="row" v-show="salud_discapacidad.posee_carnet">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="discapacidad">Grado global de discapacidad</label>
                                <input type="text" class="form-control" v-model="salud_discapacidad.discpacidad" id="discapacidad">

                            </div>
                            <div class="col-md-6">
                                <label for="causa_principal">Causa Principal</label>
                                <input type="text" class="form-control" v-model="salud_discapacidad.causa_principal" id="causa_principal">

                            </div>
                            <div class="col-md-6">
                                <label for="causa_secundaria">Causa Secundaria</label>
                                <input type="text" class="form-control" v-model="salud_discapacidad.causa_secundaria" id="causa_secundaria">

                            </div>
                            <div class="col-md-6">
                                <label for="capacidad_reducidad">Movilidad Reducida</label>
                                <select name="" class="form-control" v-model="salud_discapacidad.capacidad_reducidad" id="capacidad_reducidad">
                                    <option value="">------</option>
                                    <option value="si">SI</option>
                                    <option value="no">NO</option>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-5">
                            <label for="posee_carnet_discapacidad" class="form-check-label">Enfermedad prexistente</label>
                        </div>
                        <div class="col-md-3">

                            <label class="switch s-icons s-outline s-outline-success  mr-2">
                                <input type="checkbox" id="posee_alergias" v-model="alergias.enfermedad_prexistente" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    <div v-show="alergias.enfermedad_prexistente">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="tipo_sangre">Tipo de Sangre</label>
                                <select name="" class="form-control" v-model="salud_enfemedades.tipo_sangre" id="tipo_sangre">
                                    <option value="">------</option>
                                    <option v-for="(tipo, index) in tipo_sangres" :value="tipo">{{tipo}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3" >
                            <div class="col-md-12">
                                <label for="enfermedades">Informe cuales son sus enfermedades prexistente</label>
                                <textarea class="form-control" v-model="salud_enfemedades.enfermedades"  id="enfermedades" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="row mt-3" >
                            <div class="col-md-12">
                                <label for="medicamentos">Medicamentos</label>
                                <textarea class="form-control" v-model="salud_enfemedades.medicamentos"  id="medicamentos" cols="30" rows="10"></textarea>
                            </div>
                        </div>


                    </div>

                </div>

                <div class="modal-footer">

                </div>

            </div>
        </div>
    </div>

</template>

<script>
import {mapState} from "vuex";

export default {
    computed:{
        ...mapState('Enfermedad',['salud_discapacidad','salud_enfemedades'])
    },
    data() {
        return {
            /*salud_discapacidad:{
                posee_carnet:false,
                discpacidad:'',
                causa_principal:'',
                causa_secundaria:'',
                capacidad_reducidad:''
            },

            enfermedades:{
                tipo_sangre:'',
                enfermedades:'',
                medicamentos:''
            },*/
            alergias:{
                enfermedad_prexistente:false,
                tipo_alergia:''
            },
            tipo_sangres:[
                'A positivo (A +)',
                'A negativo (A-)',
                'B positivo (B +)',
                'B negativo (B-)',
                'AB positivo (AB+)',
                'AB negativo (AB-)',
                'O positivo (O+)',
                'O negativo (O-)'
            ]
        }
    },
}
</script>

<style scoped>

</style>
