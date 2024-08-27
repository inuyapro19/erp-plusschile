<template>
    <CardComponent :title="'Destinatarios'">
        <template #body>
            <div class="row my-3">
                <div class="col-md-12">
                    <button class="btn btn-sm btn-success" @click="abrirModel"><i class="fa fa-plus-circle"></i> Agregar</button>
                </div>
            </div>
            <SimpleTable :columns="columns"
                         :data="destinatarios"
                         :actions="true"
                         @edit="abrirModel"
                         @delete="eliminar"
            />
            <!-- Modal -->
            <BootstrapModal  :id="'createDestinatarioModel'"
                             :title="'Agregar Destinatario'"
                             :customClass="'modal-dialog-centered mw-650px'"
                             :hideCloseButton="false"
                             :onCloseButton="cerrarModal">
                <template #body>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fs-6 fw-semibold mb-2" for="name">Email</label>
                                <input type="text" v-model="email" name="name" id="email"  class="form-control">
                            </div>

                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fs-6 fw-semibold mb-2" for="name">Tipo</label>
                                <select class="form-select form-select-solid">
                                    <option v-for="modulos in tipos" :value="modulos">{{modulos}}</option>
                                </select>

                            </div>

                        </div>
                    </div>

                </template>
                <template #footer>
                    <!-- Contenido del pie de página del modal -->
                    <button
                        type="button"
                        class="btn btn-primary btn-sm"
                        @click.prevent="agregarDestinatario()"
                    >
                        Guardar
                    </button>

                </template>
            </BootstrapModal>

        </template>
    </CardComponent>
</template>

<script>
import CardComponent from "@/components/CardComponent.vue";
import BootstrapModal from "@/components/modalComponent.vue";
import SimpleTable from "@/components/simpleTable.vue";

export default {
    components: {
        BootstrapModal,
        SimpleTable,
        CardComponent
    },
    data() {
        return {
            destinatarios: [],
            email: '',
            tipos:['reporte diario', 'reporte checklist calidad','reporte checklist prevencion'],
            type: 'reporte diario',
            columns: [
                {title: 'ID', field: 'id'},
                {title: 'Destinatarios', field: 'email'},
            ],
            destinatario_id: 0
        }
    },
    mounted() {
        this.obtenerDestinatarios();
    },
    methods: {
       async obtenerDestinatarios() {
           await axios.get('/getDestinarios')
                .then(response => {
                    this.destinatarios = response.data;
                });
        },
        abrirModel(id = 0){
           if (id > 0){
               this.destinatario_id = id
               this.email = this.destinatarios.find(destinatario => destinatario.id === id).email
               this.type = this.destinatarios.find(destinatario => destinatario.id === id).type
           }

            $('#createDestinatarioModel').modal('show')
        },
        cerrarModal(){
            this.email = ''
            this.type = 'personal'

            $('#createDestinatarioModel').modal('hide')
        },
        agregarDestinatario() {
            let mensajeConfirmacion = this.destinatario_id ? "¿Quieres actualizar este destinatario?" : "¿Quieres agregar este destinatario?";
            let mensajeExito = this.destinatario_id ? "El destinatario ha sido actualizado." : "El destinatario ha sido agregado.";
            let mensajeError = this.destinatario_id ? "No se pudo actualizar el destinatario." : "No se pudo agregar el destinatario.";

            swal.fire({
                title: mensajeConfirmacion,
                text: "Confirma si deseas proceder con la acción.",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, proceder!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const url = this.destinatario_id ? `/destinatarios/${this.destinatario_id}` : '/destinatarios';
                    const method =  'post';

                    axios({ method, url, data: { email: this.email, type: this.type } })
                        .then(response => {
                            this.obtenerDestinatarios();
                            this.destinatario_id = 0;
                            this.email = '';
                            this.type = 'reporte diario';
                            this.cerrarModal();
                            swal.fire(
                                'Completado!',
                                mensajeExito,
                                'success'
                            )
                        }).catch(error => {
                        swal.fire(
                            'Error!',
                            mensajeError,
                            'error'
                        )
                    });
                }
            });
        },


        async eliminar(id) {
            swal.fire({
                title: "¿Estás seguro?",
                text: "Una vez eliminado, no podrás recuperar este registro!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/destinatarios/' + id)
                        .then(response => {
                            this.obtenerDestinatarios();
                            swal.fire(
                                'Eliminado!',
                                'El destinatario ha sido eliminado.',
                                'success'
                            )
                        }).catch(error => {
                        swal.fire(
                            'Error!',
                            'No se pudo eliminar el destinatario.',
                            'error'
                        )
                    });
                }
            });
        }

    }
}
</script>

