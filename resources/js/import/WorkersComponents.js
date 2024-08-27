// WorkersComponents.js
import IndexComponent from '../app/trabajadores/Create.vue';
import ConfiguracionComponent from '../app/configuracion/IndexComponent.vue';
import TrabajoresImportar from '../app/import/import.vue';
import PerfilTrabajador from '../app/perfil/indexComponent.vue';
import TablaDesvinculados from '../app/desvinculados/Desvinculados.vue';
import Reincorparar from '../app/reintegracion/reintegracion.vue';
import TramitesLicenciasComponent from '../app/tramite/Index.vue';
import TramitesCreateComponent from '../app/tramite/Create.vue';
import VacacionesTrabajadoresComponent from '../app/vacaciones/IndexComponent.vue';
import VacacionesCreateComponent from '../app/vacaciones/Create.vue';
import TrabajoresTablaComponent from '../app/trabajadores/Trabajadores.vue';

Vue.component('index-component', IndexComponent);
Vue.component('configuracion-component', ConfiguracionComponent);
Vue.component('trabajores-tabla-component', TrabajoresTablaComponent);
Vue.component('trabajores-importar', TrabajoresImportar);
Vue.component('perfil-trabajador', PerfilTrabajador);
Vue.component('tabla-desvinculados', TablaDesvinculados);
Vue.component('reincorparar', Reincorparar);
Vue.component('tramites-licencias-component', TramitesLicenciasComponent);
Vue.component('tramites-create-component', TramitesCreateComponent);
Vue.component('vacaciones-trabajadores-component', VacacionesTrabajadoresComponent);
Vue.component('vacaciones-create-component', VacacionesCreateComponent);
