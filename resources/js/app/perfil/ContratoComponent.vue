<template>
    <div class="col-md-11 mx-auto">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="empleador">Empleador</label>
                    <input type="text" id="empleador" v-model="trabajador.contrato.empleador.nombre_empleador" class="form-control" :disabled="desabilitado">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="ubicacion">Ubicación</label>
                    <input type="text" id="ubicacion" v-model="trabajador.contrato.ubicacion.nombre_ubicacion" class="form-control" :disabled="desabilitado">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="area">Area</label>
                    <input type="text" id="area" v-model="trabajador.contrato.area.descripcion_area" class="form-control" :disabled="desabilitado">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="cargo">Cargo</label>
                    <input type="text" id="cargo" v-model="trabajador.contrato.cargo.nombre_cargo" class="form-control" :disabled="desabilitado">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapState} from "vuex";

export default {
   computed:{
       ...mapState('trabajador',['trabajador'])
   },
    data() {
        return {
            desabilitado:true,
        }
    },
}
</script>

<style scoped>

</style>
