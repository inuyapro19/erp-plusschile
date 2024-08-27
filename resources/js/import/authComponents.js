// authComponents.js
import LoginComponent from '@/app/auth/Login.vue';
import ChangePassword from '@/app/perfil/cambiar_password.vue';
import Profiles from '@/app/profile/Index.vue';

// Luego, puedes registrar el componente como de costumbre.
Vue.component('login-component', LoginComponent);
Vue.component('cambio_password',ChangePassword);
Vue.component('profiles',Profiles);

