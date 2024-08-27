<template>
    <div class="row my-5 mx-5">
        <!-- Tipo de Entidad -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Tipo de Entidad</label>
            <select v-model="tipo_ahorro" class="form-select form-select-solid">
                <option value="">-----</option>
                <option v-for="(tipo, index) in tiposAhorro" :key="index" :value="tipo.value">{{ tipo.name }}</option>
            </select>
        </div>

        <!-- Entidad -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Entidad</label>
            <select v-model="ahorro_voluntario_id" class="form-select form-select-solid">
                <option value="">-----</option>
                <option v-for="ahorro in ahorroVoluntario" :key="ahorro.id" :value="ahorro.id">{{
                        ahorro.nombre
                    }}
                </option>
            </select>
        </div>

        <!-- Tipo de Moneda -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Tipo de Moneda</label>
            <select v-model="tipo_moneda" class="form-select form-select-solid">
                <option value="">-----</option>
                <option v-for="(tipo, index) in tiposMoneda" :key="index" :value="tipo.value">{{ tipo.name }}</option>
            </select>
        </div>

        <!-- Monto -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Monto</label>
            <input v-model.number="monto" type="number" class="form-control form-control-solid"/>
        </div>

        <!-- Forma de Pago -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Forma de Pago</label>
            <select v-model="forma_pago" class="form-select form-select-solid">
                <option value="">-----</option>
                <option v-for="(forma, index) in formasPago" :key="index" :value="forma.value">{{ forma.name }}</option>
            </select>
        </div>

        <!-- Fecha de Ingreso -->
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Fecha de Ingreso</label>
            <input v-model="fecha_ingreso" type="date" class="form-control form-control-solid"/>
        </div>

        <!-- Acciones -->
        <div class="col-12">
            <button v-if="!isEditing" @click="addAhorroVoluntario" type="button" class="btn btn-primary">Agregar
            </button>
            <button v-else @click="updateAhorroVoluntario" type="button" class="btn btn-warning">Actualizar</button>
        </div>


        <div class="row mt-5">
            <div class="col-md-12">
                <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5 dataTable no-footer">
                    <thead>
                    <tr>
                        <th>Tipo Ahorro</th>
                        <th>Entidad</th>
                        <th>Moneda</th>
                        <th>Monto</th>
                        <th>Forma Pago</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="ahorro in AhorroVoluntario" :key="ahorro ? ahorro.id : ''"
                        v-if="AhorroVoluntario && AhorroVoluntario.length">

                        <td>{{ ahorro.tipo_ahorro }}</td>
                        <td>{{ ahorro.ahorro_voluntario_id }}</td>
                        <td>{{ ahorro.tipo_moneda }}</td>
                        <td>{{ ahorro.monto }}</td>
                        <td>{{ ahorro.forma_pago }}</td>
                        <td>
                            <button @click="editarAhorroVoluntario(ahorro.id)" type="button" class="btn btn-sm btn-primary">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button @click="deleteAhorroVoluntario(ahorro.id)" type="button" class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>


    </div>
</template>

<script>
import {mapActions, mapState} from 'vuex';
import Swal from 'sweetalert2';

export default {
    props: {
        form: {
            type: Object,
            default: () => ({})
        }
    },
    data() {
        return {
            AhorroVoluntario: [],
            isEditing: false,
            formasPago: [
                {name: 'Descuento por planilla', value: 'descuento por planilla'},
                {name: 'Pago directo', value: 'pago directo'}
            ],
            tiposAhorro: [
                {name: 'APV Regimen A', value: 'apv regimen a'},
                {name: 'APV Regimen B', value: 'apv regimen b'},
                {name: 'APV Regimen C', value: 'apv regimen c'}
            ],
            tiposMoneda: [
                {name: 'Peso', value: 'peso'},
                {name: 'Dólar', value: 'dolar'},
                {name: 'Euro', value: 'euro'}
            ],
            //agregado todo los model
            tipo_ahorro: '',
            ahorro_voluntario_id: '',
            tipo_moneda: '',
            monto: null,
            forma_pago: '',
            fecha_ingreso: '',
            fecha_vencimiento: '',
            id:''
        };
    },
    computed: {
        ...mapState({
            ahorroVoluntario: state => state.prevision.prevision_apv,
        })
    },
    mounted() {
        this.getPrevision();
    },
    methods: {
        ...mapActions({
            getPrevision: 'prevision/fetchPrevisionApv',
        }),
        resetForm() {

               //reset para los models
            this.id = '';
            this.tipo_ahorro = '';
            this.ahorro_voluntario_id = '';
            this.tipo_moneda = '';
            this.monto = null;
            this.forma_pago = '';
            this.fecha_ingreso = '';
            this.fecha_vencimiento = '';



        },
        addAhorroVoluntario() {
            // Validar campos requeridos
            if (!this.tipo_ahorro || !this.ahorro_voluntario_id || !this.tipo_moneda || this.monto === null || !this.forma_pago || !this.fecha_ingreso) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Por favor, complete todos los campos requeridos.',
                });
                return;
            }

            // Crear el nuevo objeto de ahorro voluntario
            const nuevoAhorro = {
                id: Date.now(), // Usar timestamp para un ID único
                tipo_ahorro: this.tipo_ahorro,
                ahorro_voluntario_id: this.ahorro_voluntario_id,
                tipo_moneda: this.tipo_moneda,
                monto: this.monto,
                forma_pago: this.forma_pago,
                fecha_ingreso: this.fecha_ingreso,
                // fecha_vencimiento no se está usando, pero se puede agregar si es necesario
            };

            // Añadir el nuevo objeto al array AhorroVoluntario
            this.AhorroVoluntario.push(nuevoAhorro);
            this.form.ahorros = [...this.AhorroVoluntario];

            // Notificación al usuario
            Swal.fire({
                icon: 'success',
                title: '¡Añadido!',
                text: 'El ahorro voluntario ha sido añadido exitosamente.',
            });

            // Resetear el formulario
            this.resetForm();
        },
        editarAhorroVoluntario(id) {
            const index = this.AhorroVoluntario.findIndex(ahorro => ahorro.id === id);
            if (index !== -1) {
                // Establecer el modo de edición y asignar valores para editar
                this.isEditing = true;

                const ahorroSeleccionado = this.AhorroVoluntario[index];
                this.id = ahorroSeleccionado.id;
                this.tipo_ahorro = ahorroSeleccionado.tipo_ahorro;
                this.ahorro_voluntario_id = ahorroSeleccionado.ahorro_voluntario_id;
                this.tipo_moneda = ahorroSeleccionado.tipo_moneda;
                this.monto = ahorroSeleccionado.monto;
                this.forma_pago = ahorroSeleccionado.forma_pago;
                this.fecha_ingreso = ahorroSeleccionado.fecha_ingreso;
                // No olvide agregar cualquier otro campo que necesite ser editado aquí
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ahorro voluntario no encontrado.',
                });
            }
        },
        updateAhorroVoluntario() {
            const index = this.AhorroVoluntario.findIndex(ahorro => ahorro.id === this.id);

            if (index !== -1) {
                // Actualizar el objeto de ahorro voluntario directamente con $set
                this.$set(this.AhorroVoluntario, index, {
                    id: this.ahorro_voluntario_id,
                    tipo_ahorro: this.tipo_ahorro,
                    ahorro_voluntario_id: this.ahorro_voluntario_id,
                    tipo_moneda: this.tipo_moneda,
                    monto: this.monto,
                    forma_pago: this.forma_pago,
                    fecha_ingreso: this.fecha_ingreso,
                    // Agregar cualquier otro campo que necesite ser actualizado
                });

                // Actualizar form.ahorros para que sea un reflejo plano de AhorroVoluntario
                this.form.ahorros = [...this.AhorroVoluntario];

                // Notificación al usuario
                Swal.fire({
                    icon: 'success',
                    title: 'Actualizado',
                    text: 'El ahorro voluntario ha sido actualizado exitosamente.',
                });

                this.isEditing = false;
                this.resetForm();
            } else {
                // Notificar al usuario que el ahorro no existe o no se encontró
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se encontró el ahorro voluntario para actualizar.',
                });
            }
        },
        deleteAhorroVoluntario(id) {
            Swal.fire({
                title: '¿Está seguro?',
                text: "No podrá revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, borrarlo!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.AhorroVoluntario = this.AhorroVoluntario.filter(ahorro => ahorro.id !== id);
                    this.form.ahorros = [...this.AhorroVoluntario];

                    Swal.fire(
                        'Borrado!',
                        'El ahorro voluntario ha sido borrado.',
                        'success'
                    );
                }
            });
        },

    }
};
</script>

