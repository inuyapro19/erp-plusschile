// CheckListComponents.js
import ChecklistCalidadIndex from '@/app/checklist/calidad/Index.vue';
import ChecklistCalidadCreate from '@/app/checklist/calidad/create.vue';
import ChecklistConfiguracionIndex from '@/app/checklist/Configuracion/Index.vue';
import TicketCalidadIndex from '@/app/checklist/ticket/Index.vue';
import BarChart from '@/app/checklist/graficos/Barra.vue';
import Circle from "../app/checklist/graficos/Circle.vue";
import BarDoble from "../app/checklist/graficos/BarDoble.vue";
import CardResumen from '@/app/checklist/graficos/CardResumen.vue';
import ItemReincidencias from "@/app/checklist/ticket/ItemReincidencias.vue";

Vue.component('checklist-calidad-index', ChecklistCalidadIndex);
Vue.component('checklist-calidad-create', ChecklistCalidadCreate);
Vue.component('checklist-configuracion-index', ChecklistConfiguracionIndex);
Vue.component('ticket-calidad-index', TicketCalidadIndex);
Vue.component('bar-chart', BarChart);
Vue.component('card-resumen-component', CardResumen);
Vue.component('circle-chart', Circle);
Vue.component('bar-doble', BarDoble);
Vue.component('item-reincidencias', ItemReincidencias);

// Path: resources/js/import/SettingComponents.js


