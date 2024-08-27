<template>
    <div class="col-lg-11 mx-auto">
        <button type="button" class="btn btn-success btn-sm" @click="openModal(0)"><i class="fa fa-plus"></i> Agregar
        </button>
        <div class="row mt-3">
            <div class="col-md-12">
                <simpleTable
                    :data="cargos"
                    :columns="columns"
                    @delete="eliminarCargo"
                    @edit="openModal"/>
            </div>
        </div>

        <!-- Modal -->
        <NewModal id="CargosModelAdd" title="Agregar Cargo" @close="closeModal" @confirm="guardarCargo">
            <div class="row">
                <div class="col-md-12">
                    <label for="nombre_cargo">Nombre Cargo</label>
                    <input type="text" v-model="nombre_cargo" id="nombre_cargo" class="form-control">
                </div>
            </div>
        </NewModal>

    </div>
</template>

<script>
import {ref, reactive, toRefs, onMounted} from 'vue'
import Swal from 'sweetalert2'
import simpleTable from '../../../components/simpleTable.vue'
import NewModal from '../../../components/NewModal.vue'
import {cargarCargos} from "../../../helpers/Global";

export default {
    components: {
        simpleTable,
        NewModal
    },
    setup() {
        const cargos = ref([])
        const id = ref(0)
        const nombre_cargo = ref('')
        const columns = reactive([
            {title: 'ID', field: 'id'},
            {title: 'Cargo', field: 'nombre_cargo'},
            {title: 'Acciones', field: 'acciones'}
        ])

        const openModal = (idValue = 0) => {
            id.value = idValue
            if (idValue == 0) {
                nombre_cargo.value = ''
            } else {
                let cargo = cargos.value.find((item) => item.id === id.value);
                nombre_cargo.value = cargo.nombre_cargo
            }
            $('#CargosModelAdd').modal('show')
        }

        const guardarCargo = async () => {
            let method = id.value == 0 ? axios.post : axios.put;
            let url = id.value == 0 ? '/cargos' : '/cargos/' + id.value;
            await method(url, {nombre_cargo: nombre_cargo.value}).then((res) => {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: id.value == 0 ? 'Cargo creado exitosamente' : 'Cargo editado exitosamente'
                })
                cargarCargos()
                nombre_cargo.value = ''
                $('#CargosModelAdd').modal('hide')
            }).catch((error) => {
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Error al enviar el formulario'
                })
            })
        }

        const eliminarCargo = async (id) => {
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
                    axios.delete('/cargos/' + id).then((res) => {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Cargo eliminado exitosamente'
                        })
                        cargarCargos()
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
            nombre_cargo.value = ''
            $('#CargosModelAdd').modal('hide')
        }
        onMounted(async () => {
            cargos.value = await cargarCargos();
        });
        return {
            cargos,
            id,
            nombre_cargo,
            columns,
            cargarCargos,
            openModal,
            guardarCargo,
            eliminarCargo,
            closeModal
        }
    }
}
</script>

<style scoped>

</style>
