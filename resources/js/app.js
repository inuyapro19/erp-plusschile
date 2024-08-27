/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
// Bootstrap and Vue setup
require('./bootstrap');
window.Vue = require('vue').default;
// Importing required modules
import Vuex from 'vuex';
import Vuelidate from 'vuelidate';
import VuePaginate from 'vue-paginate';
import CKEditor from 'ckeditor4-vue';
import VueProgressBar from 'vue-progressbar';
import VueSweetalert2 from 'vue-sweetalert2';
import DataTable from 'laravel-vue-datatable';
import VueEllipseProgress from 'vue-ellipse-progress';
import vSelect from 'vue-select'




// Importing CSS
import 'sweetalert2/dist/sweetalert2.min.css';
import VueApexCharts from 'vue-apexcharts'
// Importing helper functions
import  './helpers/filtros';
import  './helpers/functions';



// Using imported modules
Vue.use(Vuex);
Vue.use(Vuelidate);
Vue.use(require('vue-moment'));
Vue.use(VuePaginate);
Vue.use(CKEditor);
Vue.use(DataTable);
Vue.use(VueEllipseProgress);
Vue.use(VueApexCharts)
// Progress bar configuration
const progressBarr = {
    color: '#bffaf3',
    failedColor: '#874b4b',
    thickness: '5px',
    transition: {
        speed: '0.2s',
        opacity: '0.6s',
        termination: 300
    },
    autoRevert: true,
    location: 'top',
    inverse: false
};

Vue.use(VueProgressBar, progressBarr);

// Sweetalert2 configuration
const options = {
    confirmButtonColor: '#41b882',
    cancelButtonColor: '#ff7674',
};

Vue.use(VueSweetalert2,options);





require('./import/authComponents.js');
require('./import/WorkersComponents.js');
require('./import/SolicitudesComponents.js');
require('./import/SettingComponents.js');
require('./import/Travels.js');
require('./import/CheckListComponents.js');
require('./import/CheckListPrevencionComponents.js');
Vue.component('v-select', vSelect)
Vue.component('apexchart', VueApexCharts)

import 'vue-select/dist/vue-select.css';

import store from './store'



const app = new Vue({
    el: '#app',
    store,
    CKEditor,
    VueSweetalert2,
});
