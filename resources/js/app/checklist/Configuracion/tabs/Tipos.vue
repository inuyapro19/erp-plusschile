<template>
    <div class="col-lg-11 mx-auto">
        <button type="button" class="btn btn-success btn-sm" @click="openModal(0)"><i class="fa fa-plus"></i> Agregar
        </button>
        <div class="row mt-3">
            <div class="col-md-12">
                <simpleTable
                    :data="tipos"
                    :columns="columns"
                    @delete="eliminarTipo"
                    @edit="openModal"/>
            </div>
        </div>

        <!-- Modal -->
        <BootstrapModal  :id="'TipoModalAdd'"
                         :title="'Agregar Tipo'"
                         :customClass="'modal-dialog-centered mw-650px'"
                         :hideCloseButton="false"
                         :onCloseButton="closeModal">
           <template #body>
               <div class="form fv-plugins-bootstrap5 fv-plugins-framework">
                   <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                       <label class="fs-6 fw-semibold mb-2" for="">Nombre Tipo</label>
                       <input type="text" v-model="name" id="name" class="form-control form-control-solid">
                   </div>
                   <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                       <label class="fs-6 fw-semibold mb-2" for="">Descripción Tipo</label>
                       <input type="text" v-model="description" id="description" class="form-control form-control-solid">
                   </div>
                   <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                       <label class="fs-6 fw-semibold mb-2" for="">Categoria</label>
                       <select v-model="category_id" id="category_id" class="form-select form-select-solid">
                           <option v-for="categoria in categorias" :value="categoria.id">{{ categoria.name }}</option>
                       </select>
                   </div>
               </div>
              </template>
            <template #footer>
                <!-- Contenido del pie de página del modal -->
                <button
                    type="button"
                    class="btn btn-primary btn-sm"
                    @click.prevent="guardarTipo()"
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
            tipos: [],
            categorias: [],
            id: 0,
            name: '',
            description: '',
            category_id: '',
            columns: [
                {title: 'ID', field: 'id'},
                {title: 'Nombre', field: 'name'},
                {title: 'Descripción', field: 'description'},
                {title: 'Categoria', field: 'category.name'},
                {title: 'Acciones', field: 'acciones'}
            ]
        }
    },
    methods: {
         async cargarTipos (){
            try {
                const {data, status} = await axios.get('/checklist/tipo')
                if (status === 200){
                   this.tipos = data
                }

            }
            catch (e) {
                console.log(e)
            }
        },
        async getCategories (){
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
                this.category_id = ''
            } else {
                let tipo = this.tipos.find((item) => item.id === this.id);
                this.name = tipo.name
                this.description = tipo.description
                this.category_id = tipo.category_id
            }
            $('#TipoModalAdd').modal('show')
        },
        async guardarTipo() {
            let method =  axios.post
            let url = this.id == 0 ? '/checklist/tipo' : '/checklist/tipo/' + this.id;
            await method(url, {name: this.name, description: this.description, category_id: this.category_id}).then((res) => {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: this.id == 0 ? 'Tipo creado exitosamente' : 'Tipo editado exitosamente'
                })
                this.cargarTipos()
                this.name = ''
                this.description = ''
                this.category_id = ''
                $('#TipoModalAdd').modal('hide')
            }).catch((error) => {
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Error al enviar el formulario'
                })
            })
        },
        async eliminarTipo(id) {
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
                    axios.delete('/checklist/tipo/' + id).then((res) => {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Tipo eliminado exitosamente'
                        })
                        this.cargarTipos()
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
            this.category_id = ''
            $('#TipoModalAdd').modal('hide')
        }
    },
    mounted() {
        this.cargarTipos();
        this.getCategories();
    }
}
</script>

<style scoped>

</style>
