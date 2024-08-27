<template>
    <CardComponent :title="'Crear Bus'">
        <template #header>
            <div class="row" v-show="edit">
                <div class="col-md-12">
                    <div class="btn-group mb-3">
                        <button class="btn btn-danger btn-sm" @click="editar_buses">Editar</button>
                    </div>
                </div>
            </div>
        </template>
        <template #body>

            <div class="row" v-show="edit">
                <div class="col-md-4 form-group">
                    <label class="fs-6 fw-semibold mb-2" for="estado">Estado</label>
                    <select name="estado" v-model="estado" :disabled="desabilitado" id="estado"
                            class="form-select form-select-solid">
                        <option value="">-------</option>
                        <option v-for="(estado, index) in estados_array" :value="estado">{{ estado }}</option>
                    </select>
                </div>
            </div>
            <div class="row">

                <div class="col-md-4 form-group">
                    <label class="fs-6 fw-semibold mb-2" for="patente">Patente</label>
                    <input type="text" v-model="patente" :disabled="desabilitado" id="patente"
                           class="form-control form-control-solid">
                </div>
                <div class="col-md-4 form-group">
                    <label class="fs-6 fw-semibold mb-2" for="numero_bus">Nro de bus</label>
                    <input type="number" v-model="numero_bus" :disabled="desabilitado" id="numero_bus"
                           class="form-control form-control-solid">
                </div>
                <div class="col-md-4 form-group">
                    <label class="fs-6 fw-semibold mb-2" for="marca_chasis">Marca de Chasis</label>
                    <input type="text" v-model="marca_chasis" :disabled="desabilitado" id="marca_chasis"
                           class="form-control form-control-solid">
                </div>

                <div class="col-md-4 form-group">
                    <label class="fs-6 fw-semibold mb-2" for="modelo_chasis">Modelo de Chasis</label>
                    <input type="text" v-model="modelo_chasis" :disabled="desabilitado" id="modelo_chasis"
                           class="form-control form-control-solid">
                </div>

                <div class="col-md-4 form-group">
                    <label class="fs-6 fw-semibold mb-2" for="marca_carroseria">Marca Carroceria</label>
                    <input type="text" v-model="marca_carroseria" :disabled="desabilitado" id="marca_carroseria"
                           class="form-control form-control-solid">
                </div>
                <div class="col-md-4 form-group">
                    <label class="fs-6 fw-semibold mb-2" for="modelo_carroseria">Modelo Carroceria</label>
                    <input type="text" v-model="modelo_carroseria" :disabled="desabilitado" id="modelo_carroseria"
                           class="form-control form-control-solid">
                </div>
                <div class="col-md-4 form-group">
                    <label class="fs-6 fw-semibold mb-2" for="numero_carroceria">Numero de Carroceria</label>
                    <input type="text" v-model="numero_carroceria" :disabled="desabilitado" id="numero_carroceria"
                           class="form-control form-control-solid">
                </div>
                <div class="col-md-4 form-group">
                    <label class="fs-6 fw-semibold mb-2" for="anyo">Año del bus</label>
                    <input type="number" v-model="anyo_bus" :disabled="desabilitado" id="anyo"
                           class="form-control form-control-solid">
                </div>
                <div class="col-md-4 form-group">
                    <label class="fs-6 fw-semibold mb-2" for="tipo_bus">Tipo bus</label>
                    <select name="tipo_bus" v-model="tipo_bus" :disabled="desabilitado" id="empleador_id"
                            class="form-select form-select-solid">
                        <option value="">-------</option>
                        <option v-for="(tipo_bus, index) in tipos_buses" :value="tipo_bus">{{ tipo_bus }}</option>
                    </select>
                </div>

                <div class="col-md-4 form-group">
                    <label class="fs-6 fw-semibold mb-2" for="tipo_servicio">Tipo servicio</label>
                    <select v-model="tipo_servicio" id="tipo_servicio" :disabled="desabilitado"
                            class="form-select form-select-solid">
                        <option value="">-----------</option>
                        <option value="comercial">Comercial</option>
                        <option value="minero">Minero</option>
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label class="fs-6 fw-semibold mb-2" for="numero_piso">Numero de piso</label>

                    <input type="number" v-model="numero_piso" :disabled="desabilitado" id="anyo"
                           class="form-control form-control-solid">
                </div>
            </div>

            <div class="row">

                <div class="col-md-4 form-group">
                    <label class="fs-6 fw-semibold mb-2" for="empleador_id">Propietario</label>
                    <select name="empleador_id" v-model="empleador_id" :disabled="desabilitado" id="empleador_id"
                            class="form-select form-select-solid">
                        <option value="">-------</option>
                        <option v-for="(propietario, index) in empleadores" :value="propietario.id">
                            {{ propietario.nombre_empleador }}
                        </option>
                    </select>
                </div>

            </div>
            <h3 class="mt-3">Asientos Buses</h3>
            <div class="alert alert-warning">
                * Presione enter al ingresar el valor de los asientos
            </div>
            <div class="row">
                <div class="col-md-4 form-group">
                    <label class="fs-6 fw-semibold mb-2" for="numero_asientos">Numero de asientos total</label>
                    <input type="text" v-model="numero_asientos" id="numero_asientos" :disabled="true"
                           class="form-control form-control-solid">
                </div>
                <div class="col-md-4 form-group">
                    <label class="fs-6 fw-semibold mb-2" for="numero_asientos_premuim">Numero de asientos
                        premium</label>
                    <input type="text" v-model="numero_asiento_premium" :disabled="desabilitado"
                           id="numero_asientos_premuim" @input="suma_total_asientos"
                           class="form-control form-control-solid">
                </div>
                <div class="col-md-4 form-group">
                    <label class="fs-6 fw-semibold mb-2" for="numero_asientos_mixto">Numero de asientos mixto</label>
                    <input type="text" v-model="numero_asiento_mixto" :disabled="desabilitado"
                           id="numero_asientos_mixto" @input="suma_total_asientos"
                           class="form-control form-control-solid">
                </div>

                <div class="col-md-4 form-group">
                    <label class="fs-6 fw-semibold mb-2" for="numero_asiento_cama">Numero de asientos cama</label>
                    <input type="text" v-model="numero_asiento_cama" :disabled="desabilitado" id="numero_asiento_cama"
                           @input="suma_total_asientos" class="form-control form-control-solid">
                </div>

                <div class="col-md-4 form-group">
                    <label class="fs-6 fw-semibold mb-2" for="numero_asientos_semicama">Numero de asientos
                        semicama</label>
                    <input type="text" v-model="numero_asiento_semicama" :disabled="desabilitado"
                           id="numero_asientos_semicama" @input="suma_total_asientos"
                           class="form-control form-control-solid">
                </div>

            </div>
            <h3>Sistema Multimedia</h3>
            <div class="alert alert-warning">
                * Presione enter al ingresar el valor de los pantallas
            </div>
            <div class="row">
                <div class="col-md-4 form-group">
                    <label class="fs-6 fw-semibold mb-2" for="tipo_pantalla">Tipo sistema multimedia</label>
                    <select name="tipo_pantalla" v-model="tipo_pantalla" :disabled="desabilitado" id="tipo_pantalla"
                            class="form-select form-select-solid">
                        <option value="">-------</option>
                        <option v-for="(tipo_pantalla, index) in tipo_pantallas" :value="tipo_pantalla">
                            {{ tipo_pantalla }}
                        </option>
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label class="fs-6 fw-semibold mb-2" for="numero_pantallas">total pantallas</label>
                    <input type="text" v-model="numero_pantallas" id="numero_pantallas" :disabled="true"
                           class="form-control form-control-solid">
                </div>
                <div class="col-md-4 form-group">
                    <label class="fs-6 fw-semibold mb-2" for="numero_pantallas_premium">Numero de pantallas primer
                        piso</label>
                    <input type="text" v-model="numero_pantallas_premium" :disabled="desabilitado"
                           id="numero_pantallas_premium" @input="sumar_total_pantallas"
                           class="form-control form-control-solid">
                </div>
                <div class="col-md-4 form-group">
                    <label class="fs-6 fw-semibold mb-2" for="numero_pantallas_mixto">Numero de pantallas segundo
                        piso</label>
                    <input type="text" v-model="numero_pantallas_mixto" :disabled="desabilitado"
                           id="numero_pantallas_mixto" @input="sumar_total_pantallas"
                           class="form-control form-control-solid">
                </div>


                <div class="col-md-4 form-group">
                    <label class="fs-6 fw-semibold mb-2" for="fecha_ultima_carga">Fecha última carga contenido</label>
                    <input type="date" v-model="fecha_ultima_carga" :disabled="desabilitado" id="fecha_ultima_carga"
                           class="form-control">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-sm" @click.prevent="enviarFormulario"
                            :disabled="desabilitado">Guardar
                    </button>

                    <a href="/buses" class="btn btn-default btn-sm">Volver</a>
                </div>
            </div>
        </template>


    </CardComponent>
</template>

<script>
import CardComponent from '@/components/CardComponent.vue'

export default {
    components: {
        CardComponent,
    },
    data() {
        return {
            numero_bus: '',
            marca_chasis: '',
            modelo_chasis: '',
            modelo_carroseria: '',
            marca_carroseria: '',
            numero_carroceria: 0,
            tipo_bus: '',
            tipos_buses: [
                'Premium', 'Mixto', 'Cama', 'Semi Cama'
            ],
            patente: '',
            empleador_id: 0,
            anyo_bus: '',
            numero_asientos: 0,
            numero_asiento_premium: 0,
            numero_asiento_mixto: 0,
            numero_asiento_cama: 0,
            numero_asiento_semicama: 0,
            numero_pantallas: 0,
            numero_pantallas_premium: 0,
            numero_pantallas_mixto: 0,
            numero_pantallas_cama: 0,
            numero_pantallas_semicama: 0,
            fecha_ultima_carga: '',
            tipo_servicio: '',
            numero_piso: 0,
            pisos: [
                'dos pisos',
                'piso y medio'
            ],
            mensaje: '',
            respuesta: false,
            alerta: '',
            mensajes: '',
            errors: [],
            inputClass: 'form-control mb-4',
            errorsClass: '',
            empleadores: [],
            estado: '',
            estados_array: ['Avería en la vía', 'Bus operativo', 'Nombre_causas', 'Mantención preventiva', 'Sustitución de otro bus', 'Viaje Especial', 'Dado de baja'],
            tipo_pantallas: [
                'Zeus', 'HD', 'Streaming', 'HD + Streaming', 'Zeus + Streaming'
            ],
            tipo_pantalla: '',
            desabilitado: false,
            edit: false,
            busId: 0
        }
    },
    mounted() {
        this.cargarEmpleador()
        this.getBuses()
    },
    methods: {
        async cargarEmpleador() {
            try {
                const {data, status} = await axios.get('/empleador')
                if (status === 200) {
                    this.empleadores = data
                }
            } catch (error) {
                console.log(error)
            }
        },
        async enviarFormulario() {
            try {

                let url = this.edit ? '/buses/' + this.busId : '/buses'
                let formData = new FormData();

                let fields = {
                    'numero_bus': this.numero_bus,
                    'marca_chasis': this.marca_chasis,
                    'modelo_chasis': this.modelo_chasis,
                    'marca_carroceria': this.marca_carroseria,
                    'modelo_carroceria': this.modelo_carroseria,
                    'numero_carroceria': this.numero_carroceria,
                    'patente': this.patente,
                    'tipo_bus': this.tipo_bus,
                    'numero_piso': this.numero_piso,
                    'empleador_id': this.empleador_id,
                    'anyo_bus': this.anyo_bus,
                    'numero_asientos': this.numero_asientos,
                    'numero_asiento_premium': this.numero_asiento_premium,
                    'numero_asiento_mixto': this.numero_asiento_mixto,
                    'numero_asiento_cama': this.numero_asiento_cama,
                    'numero_asiento_semicama': this.numero_asiento_semicama,
                    'numero_pantallas': this.numero_pantallas,
                    'numero_pantallas_premium': this.numero_pantallas_premium,
                    'numero_pantallas_mixtos': this.numero_pantallas_mixto,
                    'numero_pantallas_cama': this.numero_pantallas_cama,
                    'numero_pantallas_semicama': this.numero_pantallas_semicama,
                    'fecha_ultima_carga': this.fecha_ultima_carga,
                    'tipo_servicio': this.tipo_servicio,
                    'tipo_pantalla': this.tipo_pantalla
                };

                if (this.busId) {

                    fields['estado'] = this.estado;
                }

                for (let key in fields) {
                    formData.append(key, fields[key]);
                }

                const {status} = await axios.post(url, formData)

                if (status === 200) {
                    this.respuesta = true
                    this.alerta = 'alert-success'
                    this.mensajes = 'Bus agregado exitosamente'

                    if (this.edit) {
                        this.$swal({
                            title: 'Bus editado exitosamente',
                            type: 'success',
                            confirmButtonText: 'Aceptar'
                        })
                        this.getBuses()
                        //setTimeout(window.location.href = "/buses", 3000);
                        window.location.href = "/buses";
                    } else {
                        this.$swal({
                            title: 'Bus agregado exitosamente',
                            type: 'success',
                            confirmButtonText: 'Aceptar'
                        });
                        this.reset()
                        window.location.href = "/buses";
                    }
                }

            } catch (error) {
                this.respuesta = true

                this.$swal({
                    title: 'Error al agregar bus',
                    type: 'error',
                    confirmButtonText: 'Aceptar'
                })
            }

        },
        async getBuses() {
            try {
                //recata el id de la ruta sin vue router
                //conviertelo a numerico
                let id = window.location.pathname.split('/')[3]
                if (id) {
                    this.edit = true
                    this.busId = id
                    this.desabilitado = true
                    const {data, status} = await axios.get('/getBuses?operador=first&edit=si&id=' + id)

                    if (status === 200) {
                        this.numero_bus = data.numero_bus
                        this.marca_chasis = data.marca_chasis
                        this.modelo_chasis = data.modelo_chasis
                        this.marca_carroseria = data.marca_carroceria
                        this.modelo_carroseria = data.modelo_carroceria
                        this.numero_carroceria = data.numero_carroceria
                        this.patente = data.patente
                        this.tipo_bus = data.tipo_bus
                        this.numero_piso = data.numero_piso
                        this.empleador_id = data.empleador_id
                        this.anyo_bus = data.anyo_bus
                        this.numero_asientos = data.numero_asientos
                        this.numero_asiento_premium = data.numero_asiento_premium
                        this.numero_asiento_mixto = data.numero_asiento_mixto
                        this.numero_asiento_cama = data.numero_asiento_cama
                        this.numero_asiento_semicama = data.numero_asiento_semicama
                        this.numero_pantallas = data.numero_pantallas
                        this.tipo_servicio = data.tipo_servicio
                        this.tipo_pantalla = data.tipo_pantalla

                        this.numero_pantallas_premium = data.numero_pantallas_premium
                        this.numero_pantallas_semicama = data.numero_pantallas_semicama
                        this.numero_pantallas_mixto = data.numero_pantallas_mixtos
                        this.numero_pantallas_cama = data.numero_pantallas_cama
                        this.fecha_ultima_carga = data.fecha_ultima_carga

                        this.estado = data.estado
                    }
                }
            } catch (error) {
                console.log(error)
            }

        },
        reset() {
            this.numero_bus = 0
            this.marca_chasis = ''
            this.modelo_chasis = ''
            this.marca_carroseria = ''
            this.modelo_carroseria = ''
            this.numero_carroceria = 0
            this.patente = ''
            this.tipo_bus = ''
            this.numero_piso = ''
            this.empleador_id = 0
            this.anyo_bus = 0
            this.numero_asientos = 0
            this.numero_asiento_premium = 0
            this.numero_asiento_mixto = 0
            this.numero_asiento_cama = 0
            this.numero_asiento_semicama = 0
            this.numero_pantallas = 0
            this.numero_pantallas_premium = 0
            this.numero_pantallas_semicama = 0
            this.numero_pantallas_mixto = 0
            this.numero_pantallas_cama = 0
            this.fecha_ultima_carga = ''
            this.tipo_servicio = ''
            this.tipo_pantalla = ''
        },
        /*  sumar_total_pantallas() {
              let suma = 0
              if (parseInt(this.numero_pantallas_semicama) > 0) {
                  suma += parseInt(this.numero_pantallas_semicama)
              }
              if (this.numero_pantallas_cama > 0) {
                  suma += parseInt(this.numero_pantallas_cama)
              }

              if (this.numero_pantallas_mixto > 0) {
                  suma += parseInt(this.numero_pantallas_mixto)
              }

              if (this.numero_pantallas_premium > 0) {
                  suma += parseInt(this.numero_pantallas_premium)
              }

              this.numero_pantallas = suma

          },
          suma_total_asientos() {
              let suma = 0

              if (parseInt(this.numero_asiento_cama) > 0) {
                  suma += parseInt(this.numero_asiento_cama)
              }

              if (this.numero_asiento_semicama > 0) {
                  suma += parseInt(this.numero_asiento_semicama)
              }

              if (this.numero_asiento_premium > 0) {
                  suma += parseInt(this.numero_asiento_premium)
              }

              if (this.numero_asiento_mixto > 0) {
                  suma += parseInt(this.numero_asiento_mixto)
              }

              this.numero_asientos = suma

          },*/

        sumar_total_pantallas() {
            const pantallas = ['numero_pantallas_semicama', 'numero_pantallas_cama', 'numero_pantallas_mixto', 'numero_pantallas_premium'];
            this.numero_pantallas = pantallas.reduce((total, pantalla) => total + parseInt(this[pantalla] || 0), 0);
        },

        suma_total_asientos() {
            const asientos = ['numero_asiento_cama', 'numero_asiento_semicama', 'numero_asiento_premium', 'numero_asiento_mixto'];
            this.numero_asientos = asientos.reduce((total, asiento) => total + parseInt(this[asiento] || 0), 0);
        },
        editar_buses() {
            this.desabilitado = !this.desabilitado;
        }
    },
}
</script>

<style scoped>

</style>
