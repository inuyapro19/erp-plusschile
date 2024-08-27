import moment from "moment";
import Vue from "vue"
//FORMATE LA FECHA EN FORMATO dia - mes - año
Vue.filter('FormatoFecha',(value)=>{
    return moment(value).format('DD-MM-YYYY')
})
// FORMATEA LOS NUMERO CON EL . DE MILES
Vue.filter('formatPrice',(value)=>{
    let val = (value/1).toFixed(0).replace('.', ',')
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
})
//FORMATEA LOS TEXTO CON LA LETRA PRINCIPAL EN MAYUSCULA
Vue.filter('capitalize',(value)=>{
    if (!value) return '';
    value = value.toString();
    return value.charAt(0).toUpperCase() + value.slice(1);
})


