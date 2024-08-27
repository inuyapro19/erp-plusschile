// SolicitudesComponents.js
import SolicitudCreate from '../app/solicitudes/IndexComponent.vue';
import SolicitudEdit from '../app/solicitudes/MisSolicitudesComponent.vue';
import CertificadoAntiguidad from '../app/documentos/Certificado_antiguidad.vue';
import DocumentoComponent from '../app/documentos/DocumentoComponent.vue';
import PerfilMisSolicitudes from '../app/solicitudes/PerfilMisSolicitudes.vue';
import SolicitudesIndex from '../app/solicitudesRespuestas/RespuestasPendientes.vue';
import FormularioRespuestas from '../app/solicitudesRespuestas/FormularioRespuesta.vue';

Vue.component('solicitud-create', SolicitudCreate);
Vue.component('solicitud-edit', SolicitudEdit);
Vue.component('Certificado_antiguidad', CertificadoAntiguidad);
Vue.component('documento-component', DocumentoComponent);
Vue.component('perfil-mis-solicitudes', PerfilMisSolicitudes);
Vue.component('solicitudes-index', SolicitudesIndex);
Vue.component('formulario-respuestas', FormularioRespuestas);
