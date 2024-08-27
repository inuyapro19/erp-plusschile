<template>
    <div class="col-lg-11 mx-auto">
        <div class="row">
            <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                <div class="form">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="rut">RUT</label>
                                <input type="text" id="rut" v-model="trabajador.rut" class="form-control" :disabled="desabilitado">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="primer_nombre">Primer Nombre</label>
                                <input type="text" id="primer_nombre" v-model="trabajador.primer_nombre" class="form-control" :disabled="desabilitado">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="segundo_nombre">Segundo Nombre</label>
                                <input type="text" id="segundo_nombre" v-model="trabajador.segundo_nombre" class="form-control" :disabled="desabilitado">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="primer_apellido">Primer Apellido</label>
                                <input type="text" v-model="trabajador.primer_apellido" id="primer_apellido" :disabled="desabilitado" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="segundo_apellido">Segundo Apellido</label>
                                <input type="text" :disabled="desabilitado" id="segundo_apellido" v-model="trabajador.segundo_apellido" class="form-control">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="fecha_nacimiento">Fecha Nacimiento</label>
                            <input type="text" :disabled="desabilitado" v-model="trabajador.fecha_nacimiento" id="fecha_nacimiento" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="telefono_celular">Télefono Móvil</label>
                                <input type="text" class="form-control" id="telefono_celular" v-model="trabajador.telefono_celular">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="telefono_local">Télefono (Opcional) </label>
                                <input type="text" class="form-control" id="telefono_local" v-model="trabajador.telefono_local">
                            </div>
                        </div>



                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="correo">Correo</label>
                                <input type="text" id="correo" class="form-control" :disabled="desabilitado" v-model="trabajador.correo">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="direccion">Dirección</label>
                                <input type="text" class="form-control" id="direccion" :disabled="desabilitado" v-model="trabajador.direccion">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="region">Región</label>
                                <input type="text" class="form-control" id="region" :disabled="desabilitado">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="comuna">Comuna</label>
                                <input type="text" class="form-control" id="comuna"  :disabled="desabilitado">
                            </div>
                        </div>

                    </div>



                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapState} from "vuex";

export default {

    computed:{
        ...mapState('trabajador',['trabajador'])
    },
    data() {
        return {
            desabilitado:true,
        }
    },
    methods: {

    },
}
</script>

<style scoped>

</style>
