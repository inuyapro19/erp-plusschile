// SettingComponents.js
import RolesComponent from '../app/roles/indexComponent.vue';
import RolesCreateComponent from '../app/roles/createComponent.vue';
import RolesAsignarComponent from '../app/roles/AsignarRoles.vue';
import PermisosComponent from '@/app/permissions/Index.vue';
import LogSistema from '../app/logSistema/Index.vue';
import DestinatariosComponent from '@/app/destinatarios/Index.vue';


Vue.component('roles-component', RolesComponent);
Vue.component('roles-create-component', RolesCreateComponent);
Vue.component('roles-asignar-component', RolesAsignarComponent);
//logs sistema
Vue.component('logs-sistema-index',LogSistema);

//permisos
Vue.component('permisos-component', PermisosComponent);

//destinatarios
Vue.component('destinatarios-component', DestinatariosComponent);
