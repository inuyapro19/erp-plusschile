<template>
    <div class="col-lg-11 mx-auto">
        <button type="button" class="btn btn-success btn-sm" @click="openModal(0)"><i class="fa fa-plus"></i> Agregar
        </button>
        <div class="row mt-3">
            <div class="col-md-12">
                <simpleTable
                    :data="categorias"
                    :columns="columns"
                    @delete="eliminarCategoria"
                    @edit="openModal"/>
            </div>
        </div>

        <!-- Modal -->
        <BootstrapModal  :id="'CategoriaModalAdd'"
                         :title="'Agregar Categoria'"
                         :customClass="'modal-dialog-centered mw-650px'"
                         :hideCloseButton="false"
                         :onCloseButton="closeModal">
           <template #body>
               <div class="form fv-plugins-bootstrap5 fv-plugins-framework">
                   <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                       <label class="fs-6 fw-semibold mb-2" for="">Nombre Categoria</label>
                       <input type="text" v-model="name" id="name" class="form-control form-control-solid">
                   </div>
                   <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                       <label class="fs-6 fw-semibold mb-2" for="">Descripción Categoria</label>
                       <input type="text" v-model="description" id="description" class="form-control form-control-solid">
                   </div>

               </div>
              </template>
            <template #footer>
                <!-- Contenido del pie de página del modal -->
                <button
                    type="button"
                    class="btn btn-primary btn-sm"
                    @click.prevent="guardarCategoria()"
                >
                    Guardar
                </button>

            </template>

        </BootstrapModal>

    </div>
</template>

<script>
import Vue from 'vue'
import Swal from 'sweetalert2'
import simpleTable from '@/components/simpleTable.vue'
import BootstrapModal from '@/components/modalComponent.vue'

export default {
    components: {
        simpleTable,
        BootstrapModal
    },
    data() {
        return {
            categorias: [],
            id: 0,
            name: '',
            description: '',
            columns: [
                {title: 'ID', field: 'id'},
                {title: 'Nombre', field: 'name'},
                {title: 'Descripción', field: 'description'},
                {title: 'Acciones', field: 'acciones'}
            ]
        }
    },
    methods: {
         async cargarCategorias (){
            try {
                const {data, status} = await axios.get('/checklist/categoria')
                if (status === 200){
                   this.categorias = data
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
                this.description = ''
            } else {
                let categoria = this.categorias.find((item) => item.id === this.id);
                this.name = categoria.name
                this.description = categoria.description
            }
            $('#CategoriaModalAdd').modal('show')
        },
        async guardarCategoria() {
            let method =  axios.post
            let url = this.id == 0 ? '/checklist/categoria' : '/checklist/categoria/' + this.id;
            await method(url, {name: this.name, description: this.description}).then((res) => {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: this.id == 0 ? 'Categoría creada exitosamente' : 'Categoría editada exitosamente'
                })
                this.cargarCategorias()
                this.name = ''
                this.description = ''
                $('#CategoriaModalAdd').modal('hide')
            }).catch((error) => {
                if (error.response && error.response.status === 422) {
                    let errors = error.response.data.errors;
                    // Aquí puedes manejar los errores. Por ejemplo, podrías mostrarlos en un alerta.
                    for (let field in errors) {
                        Swal.fire({
                            icon: 'error',
                            title: '¡Error!',
                            text: errors[field][0] // Muestra el primer error de cada campo
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
        async eliminarCategoria(id) {
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
                    axios.delete('/checklist/categoria/' + id).then((res) => {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Categoría eliminada exitosamente'
                        })
                        this.cargarCategorias()
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
            this.description = ''
            $('#CategoriaModalAdd').modal('hide')
        }
    },
    mounted() {
        this.cargarCategorias();
    }
}
</script>


<style scoped>

</style>
