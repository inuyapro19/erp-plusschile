<template>
    <div class="col-lg-11 mx-auto">
        <button type="button" class="btn btn-success btn-sm" @click="openModal(0)"><i class="fa fa-plus"></i> Agregar
        </button>
        <div class="row mt-3">
            <div class="col-md-12">
                <simpleTable
                    :data="bancos"
                    :columns="columns"
                    @delete="eliminarBanco"
                    @edit="openModal"/>
            </div>
        </div>

        <!-- Modal -->
        <NewModal id="BancoModelAdd" title="Agregar Banco" @close="closeModal" @confirm="guardarBanco">
            <div class="row">
                <div class="col-md-12">
                    <label for="nombre_banco">Descripción Banco</label>
                    <input type="text" v-model="nombre_banco" id="nombre_banco" class="form-control">
                </div>
            </div>
        </NewModal>

    </div>
</template>

<script>
import {ref, reactive, onMounted} from 'vue'
import Swal from 'sweetalert2'
import simpleTable from '../../../components/simpleTable.vue'
import NewModal from '../../../components/NewModal.vue'
import {cargarBancos} from "../../../helpers/Global";

export default {
    components: {
        simpleTable,
        NewModal
    },
    setup() {
        const bancos = ref([])
        const id = ref(0)
        const nombre_banco = ref('')
        const columns = reactive([
            {title: 'ID', field: 'id'},
            {title: 'Banco', field: 'nombre_banco'},
            {title: 'Acciones', field: 'acciones'}
        ])

        const openModal = (idValue = 0) => {
            id.value = idValue
            if (idValue == 0) {
                nombre_banco.value = ''
            } else {
                let banco = bancos.value.find((item) => item.id === id.value);
                nombre_banco.value = banco.nombre_banco
            }
            $('#BancoModelAdd').modal('show')
        }

        const guardarBanco = async () => {
            let method = id.value == 0 ? axios.post : axios.put;
            let url = id.value == 0 ? '/bancos' : '/bancos/' + id.value;
            await method(url, {nombre_banco: nombre_banco.value}).then((res) => {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: id.value == 0 ? 'Banco creado exitosamente' : 'Banco editado exitosamente'
                })
               bancos.value = cargarBancos()
                nombre_banco.value = ''
                $('#BancoModelAdd').modal('hide')
            }).catch((error) => {
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Error al enviar el formulario'
                })
            })
        }

        const eliminarBanco = async (id) => {
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
                    axios.delete('/bancos/' + id).then((res) => {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Banco eliminado exitosamente'
                        })
                     bancos.value = cargarBancos()
                    }).catch((error) => {
                        Swal.fire({
                            icon: 'error',
                            title: '¡Error!',
                            text: 'Error al eliminar'
                        })
                    })
                }
            })
        }

        const closeModal = () => {
            id.value = 0
            nombre_banco.value = ''
            $('#BancoModelAdd').modal('hide')
        }

        onMounted(async () => {
            bancos.value = await cargarBancos();
        });

        return {
            bancos,
            id,
            nombre_banco,
            columns,
            cargarBancos,
            openModal,
            guardarBanco,
            eliminarBanco,
            closeModal
        }
    }
}
</script>

<style scoped>

</style>
