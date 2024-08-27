<template>
    <Card :title="'Permisos'">
        <template #body>
            <div class="col-lg-11 mx-auto">
                <button type="button" class="btn btn-success btn-sm" @click="openModal(0)"><i class="fa fa-plus"></i> Agregar
                </button>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <simpleTable
                            :data="items"
                            :columns="columns"
                            @delete="deleteItem"
                            @edit="openModal"/>
                    </div>
                </div>

                <!-- Modal -->
                <BootstrapModal  :id="'ItemModalAdd'"
                                 :title="'Agregar Item'"
                                 :customClass="'modal-dialog-centered mw-650px'"
                                 :hideCloseButton="false"
                                 :onCloseButton="closeModal">
                    <template #body>
                        <div class="form fv-plugins-bootstrap5 fv-plugins-framework">
                            <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold mb-2" for="">Nombre</label>
                                <input type="text" v-model="name" id="name" class="form-control form-control-solid">
                            </div>
                        </div>
                    </template>
                    <template #footer>
                        <!-- Contenido del pie de página del modal -->
                        <button
                            type="button"
                            class="btn btn-primary btn-sm"
                            @click.prevent="saveItem()"
                        >
                            Guardar
                        </button>

                    </template>

                </BootstrapModal>

            </div>
        </template>
    </Card>

</template>

<script>
import Vue from 'vue'
import Swal from 'sweetalert2'
import simpleTable from '@/components/simpleTable.vue'
import BootstrapModal from '@/components/modalComponent.vue'
import Card from '@/components/CardComponent.vue'

export default {
    components: {
        simpleTable,
        BootstrapModal,
        Card
    },
    data() {
        return {
            items: [],
            id: 0,
            name: '',
            columns: [
                {title: 'ID', field: 'id'},
                {title: 'Nombre', field: 'name'},
                {title: 'Acciones', field: 'acciones'}
            ]
        }
    },
    methods: {
         async loadItems (){
            try {
                const {data, status} = await axios.get('/permissions/all')
                if (status === 200){
                   this.items = data
                }

            }
            catch (e) {
                console.log(e)
            }
        },
        openModal(idValue = 0) {
            this.id = idValue
            if (idValue == 0) {
                this.name = ''
            } else {
                let item = this.items.find((item) => item.id === this.id);
                this.name = item.name
            }
            $('#ItemModalAdd').modal('show')
        },
        async saveItem() {
            let method =  axios.post
            let url = this.id == 0 ? '/permissions' : '/permissions/' + this.id;
            await method(url, {name: this.name}).then((res) => {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: this.id == 0 ? 'Item creado exitosamente' : 'Item editado exitosamente'
                })
                this.loadItems()
                this.name = ''
                $('#ItemModalAdd').modal('hide')
            }).catch((error) => {
                if (error.response && error.response.status === 422) {
                    let errors = error.response.data.errors;
                    for (let field in errors) {
                        Swal.fire({
                            icon: 'error',
                            title: '¡Error!',
                            text: errors[field][0]
                        })
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: 'Error al enviar el formulario'
                    })
                }
            })
        },
        async deleteItem(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, bórralo!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/permissions/' + id).then((res) => {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Item eliminado exitosamente'
                        })
                        this.loadItems()
                    }).catch((error) => {
                        Swal.fire({
                            icon: 'error',
                            title: '¡Error!',
                            text: 'Error al eliminar'
                        })
                    })
                }
            })
        },
        closeModal() {
            this.id = 0
            this.name = ''
            $('#ItemModalAdd').modal('hide')
        }
    },
    mounted() {
        this.loadItems();
    }
}
</script>


<style scoped>

</style>
