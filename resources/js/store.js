import Vue from 'vue';
import Vuex from 'vuex'

import trabajador from './modulos/trabajador'
import bancos from './modulos/Banco'
import contacto from './modulos/contacto'
import cargaFamiliar  from './modulos/cargaFamiliar'
import licencia from './modulos/licencia'
import prevision from './modulos/prevision'
import Salud from "./modulos/salud"
import Ahorro from "./modulos/Ahorro"
import Enfermedad from "./modulos/enfermedad"
import Permisos from "./modulos/permisos"
//nuevos import
import {regionesModule} from "./store/regionesModule";
import {comunasModule} from "./store/comunasModule";
import {trabajadoresModule} from "./store/TrabajadoresModule";
import {movimientosTrabajadorModule} from "./store/movimientosTrabajadorModule";
import {areasModule} from "./store/areasModule";
import {bancosModule} from "./store/bancosModule";
import {cargosModule} from "./store/cargosModule";
import {empleadoresModule} from "./store/empleadoresModule";
import {nacionalidadesModule} from "./store/nacionalidadesModule";
import {previsionSaludModule} from "./store/previsionSaludModule";
import {previsionModule} from "./store/previsionModule";
import {ubicacionesModule} from "./store/ubicacionesModule";
import {pueblosModule} from "./store/pueblosModule";
import {parentescoModule} from "./store/parentescoModule";

Vue.use(Vuex)
export default new Vuex.Store({
    modules:{
       // trabajador,
        /*bancos,
        contacto,
        cargaFamiliar,
        licencia,
        prevision,
        Salud,
        Ahorro,
        Enfermedad,
        Permisos,*/
        regiones: regionesModule,
        comunas: comunasModule,
        trabajador:trabajadoresModule,
        movimientosTrabajador: movimientosTrabajadorModule,
        areas: areasModule,
        bancos: bancosModule,
        cargos: cargosModule,
        empleadores: empleadoresModule,
        nacionalidades: nacionalidadesModule,
        previsionSalud: previsionSaludModule,
        prevision: previsionModule,
        ubicaciones: ubicacionesModule,
        pueblosOrignarios: pueblosModule,
        parentesco:parentescoModule,
    },
})
