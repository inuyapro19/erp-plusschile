<template>
    <div class="col-lg-11 mx-auto">
        <button type="button" class="btn btn-success btn-sm" @click="openModal(0)"><i class="fa fa-plus"></i> Agregar
        </button>
        <div class="row mt-3">
            <div class="col-md-12">
                <simpleTable
                    :data="areas"
                    :columns="columns"
                    @delete="eliminarAreas"
                    @edit="openModal"/>
            </div>
        </div>

        <!-- Modal -->
        <NewModal id="AreasModelAdd" title="Agregar Area" @close="closeModal" @confirm="guardarArea">
            <div class="row">
                <div class="col-md-12">
                    <label class="fs-6 fw-semibold mb-2" for="">Descripción Area</label>
                    <input type="text" v-model="nombre_area" id="nombre_area" class="form-control">
                </div>
                <div class="col-md-12 mt-2">
                    <label class="fs-6 fw-semibold mb-2" for="">Encargado de area</label>
                    <select-2
                        v-model="trabajador_id"
                        dataType="number"
                        :modalId="'AreasModelAdd'"
                    >
                        <option
                            v-for="({id,rut,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido}, index) in trabajadores"
                            :value="id">
                            {{ rut + ' ' + primer_nombre + ' ' + segundo_nombre + ' ' + primer_apellido + ' ' + segundo_apellido }}
                        </option>
                    </select-2>
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
import {cargarAreas,getTrabajadores} from "../../../helpers/Global";
import Select2 from "../../../components/Form/Select2.vue";
export default {
    components: {
        Select2,
        simpleTable,
        NewModal
    },
    setup() {
        const areas = ref([])
        const trabajadores = ref([])
        const id = ref(0)
        const nombre_area = ref('')
        const trabajador_id = ref(0)
        const columns = reactive([
            {title: 'ID', field: 'id'},
            {title: 'Area', field: 'descripcion_area'},
            {title: 'Acciones', field: 'acciones'}
        ])



        const openModal = (idValue = 0) => {
            id.value = idValue
            if (idValue == 0) {
                nombre_area.value = ''
            } else {
                let area = areas.value.find((item) => item.id === id.value);
                nombre_area.value = area.descripcion_area
            }
            $('#AreasModelAdd').modal('show')
        }

        const openModalEliminar = (idValue) => {
            id.value = idValue
            $('#AreaModalDelete').modal('show')
        }

      const  getWorkers = async () => {
            try {
                const {data, status} = await axios.get('/lista-trabajadores')
                if (status === 200) {
                    trabajadores.value = data
                }

            } catch (e) {
                console.log(e)
            }
        }

        const guardarArea = async () => {
            let method = id.value == 0 ? axios.post : axios.put;
            let url = id.value == 0 ? '/areas' : '/areas/' + id.value;
            await method(url, {descripcion_area: nombre_area.value}).then((res) => {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: id.value == 0 ? 'Ubicación creada exitosamente' : 'Area editada exitosamente'
                })
                areas.value = cargarAreas()
                nombre_area.value = ''
                $('#AreasModelAdd').modal('hide')
            }).catch((error) => {
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Error al enviar el formulario'
                })
            })
        }

        const eliminarAreas = async (id) => {
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
                    axios.delete('/areas/' + id).then((res) => {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Area eliminada exitosamente'
                        })
                       areas.value = cargarAreas()
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
            nombre_area.value = ''
            $('#AreasModelAdd').modal('hide')
            //$('#AreaModalDelete').modal('hide')
        }
        onMounted(async () => {
             areas.value = await cargarAreas();
             await getWorkers();
        });
        return {
            areas,
            id,
            nombre_area,
            columns,
            trabajadores,
            trabajador_id,
            cargarAreas,
            openModal,
            guardarArea,
            eliminarAreas,
            closeModal
        }
    }
}
</script>

<style scoped>

</style>
