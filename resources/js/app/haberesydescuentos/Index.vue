<template>
    <div>

        <ul class="nav nav-tabs  mb-3 mt-3" id="simpletab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="afp-tab" data-toggle="tab" href="#bonos" role="tab" aria-controls="home" aria-selected="true">Bonos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="anticipo-tab" data-toggle="tab" href="#anticipos" role="tab" aria-controls="home" aria-selected="true">Anticipos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="horaextras-tab" data-toggle="tab" href="#horas_extras" role="tab" aria-controls="home" aria-selected="true">Hora Extras</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="haber-no-imponible-tab" data-toggle="tab" href="#haber_no_imponible" role="tab" aria-controls="home" aria-selected="true">Haber no imponible</a>
            </li>
        </ul>
        <div class="tab-content" id="simpletabContent">
            <div class="tab-pane fade show active" id="bonos" role="tabpanel"  aria-labelledby="ficha-tab">
                <bonos  :isBono="true" :categoria="'BONOS'" :modelName="'BonosModel'" :datos="bonos" />
            </div>
            <div class="tab-pane fade" id="anticipos" role="tabpanel" aria-labelledby="anticipo-tab">
                <bonos  :isBono="false" :categoria="'ANTICIPOS'" :modelName="'AnticiposModel'" :datos="anticipos" />
            </div>
            <div class="tab-pane fade" id="horas_extras" role="tabpanel" aria-labelledby="anticipo-tab">
                <bonos  :isBono="false" :categoria="'HORAS EXTRAS'" :modelName="'HorasExtrasModel'" :datos="hora_extras" />
            </div>
            <div class="tab-pane fade" id="haber_no_imponible" role="tabpanel" aria-labelledby="anticipo-tab">
                <bonos  :isBono="false" :categoria="'HABERES NO IMPONIBLES'" :modelName="'HabernoImponibleModel'" :datos="haber_no_imponible" />
            </div>
        </div>
    </div>
</template>

<script>
import bonos from "./bonos";
import Anticipos from "./anticipos";
export default {
    name: "Index",
    components:{
        bonos,
        Anticipos
    },
    data() {
        return {
            bonos:{
                descripcion:true,
                monto:true,
                tipo:true,
                clasificacion:true,
                moneda:false,
                factor:false,
                fecha_termino:false,
                aplica_gratificacion:true,
                aplica_hora_extra:true,
                aplica_anticipable:true,
                aplica_proporcional:false,
                aplica_imponible:false,
            },
            anticipos:{
                descripcion:true,
                monto:true,
                tipo:false,
                clasificacion:false,
                moneda:false,
                factor:false,
                fecha_termino:false,
                aplica_gratificacion:false,
                aplica_hora_extra:false,
                aplica_anticipable:false,
                aplica_proporcional:false,
                aplica_imponible:false,
            },
            hora_extras:{
                descripcion:true,
                monto:false,
                tipo:false,
                clasificacion:false,
                moneda:false,
                factor:true,
                fecha_termino:false,
                aplica_gratificacion:true,
                aplica_hora_extra:false,
                aplica_anticipable:false,
                aplica_proporcional:false,
                aplica_imponible:false,
            },
            haber_no_imponible:{
                descripcion:true,
                monto:true,
                tipo:false,
                clasificacion:false,
                moneda:false,
                factor:false,
                fecha_termino:false,
                aplica_gratificacion:false,
                aplica_hora_extra:false,
                aplica_anticipable:false,
                aplica_proporcional:true,
                aplica_imponible:false,
            }
        }
    },
}
</script>

<style scoped>

</style>
