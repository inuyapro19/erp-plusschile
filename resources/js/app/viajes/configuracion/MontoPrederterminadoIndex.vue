<template>
    <div class="col-lg-11 mx-auto">
        <button type="button" class="btn btn-success btn-sm" @click="openModalCreate(0)"><i class="fa fa-plus"></i> Agregar</button>
        <div class="row mt-3">
            <div class="col-md-12">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                    <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th>ID</th>
                        <th>Destino</th>
                        <th>monto</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                    <tr v-for="(montos, index) in montos_prederterminados">
                        <td>{{montos.id}}</td>
                        <td>{{montos.destino.ciudad}}</td>
                        <td>{{montos.monto_predeterminado}}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger" @click="openModalEliminar(montos.id)"  title="Eliminar"><i class="fa fa-trash"></i></button>
                            <button type="button" class="btn btn-sm btn-info"  @click="openModalCreate(montos.id)"   title="Editar"><i class="fa fa-edit"></i></button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalMonto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="fw-bold">Agregar Monto Predeterminado</h2>
                        <div id="trabajadorModal_close" @click="cerrarModal()" class="btn btn-icon btn-sm btn-active-icon-primary" >
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
								    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
								</svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="fv-row mb-7">
                                    <label  class="fs-6 fw-semibold mb-2"  for="destino_id">Destino</label>
                                    <select name="destino_id" class="form-control form-control-solid"  v-model="destino_id" id="destino_id">
                                        <option value="">----------</option>
                                        <option v-for="(destino, index) in destinos" :value="destino.id">{{destino.ciudad}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="fv-row mb-7">
                                    <label  class="fs-6 fw-semibold mb-2"  for="monto">Monto</label>
                                    <input type="number" class="form-control form-control-solid" v-model="monto" id="monto" placeholder="Monto">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" @click="cerrarModal()">Cerrar</button>
                        <button type="button"  class="btn btn-primary btn-sm" @click="enviar_formulario()">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
    </div>
</template>

<script>
export default {
    name: "MontoPrederterminadoIndex",
    data() {
        return {
          montos_prederterminados: [],
            monto:0,
            destino_id:0,
            id:0,
            destinos:[],
            editar:false
        }
    },
    created() {
        this.getMontoDestino()
        this.cargarDestinos()
    },
    methods:{
        async cargarDestinos(){
            try {
                const {data, status} = await axios.get('/destinos')
                if(status == 200) {
                    this.destinos = data
                }
            }
            catch (error){
                console.log(error)
            }
        },
        async getMontoDestino(){
            try {
                let url = '/getMontoDestino'

                const {data , status} = await axios.get(url)

                if (status == 200) {
                    this.montos_prederterminados = data
                }

            }catch (error){
                console.log(error)
            }
        },
       async enviar_formulario(){

           //url para crear o editar
            let url = ''

           if (this.editar) {
                url = '/monto-destino-store/'+this.id
            }else {
                url = '/monto-destino-store'
            }


            let formData = new FormData()
            formData.append('monto_predeterminado', this.monto)
            formData.append('destino_id', this.destino_id)

          // console.log(this.id)

           await axios.post(url, formData).then(response => {
                if (response.status == 200) {
                    this.$swal('Monto asignado correctamente')
                    this.getMontoDestino()
                    this.cerrarModal()
                }
            }).catch(error => {
                console.log(error)
            })
        },
        openModalCreate(id){
            console.log(id)
                if (id > 0) {
                    this.id = id
                    let monto = this.montos_prederterminados.find(monto => monto.id == id)
                    this.monto = monto.monto_predeterminado
                    this.destino_id = monto.destino_id
                    this.editar = true
                }else{
                    this.monto = 0
                    this.destino_id = 0
                }

            $('#modalMonto').modal('show')
        },
        cerrarModal(){
            this.monto = 0
            this.destino_id = 0
            this.id = 0
            $('#modalMonto').modal('hide')
        },
        openModalEliminar(id){
            this.$swal.fire({
                title: '¿Estas seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, ¡Bórralo!',
                cancelButtonText: 'No, ¡cancelar!',
                reverseButtons: false
            }).then((result) => {
                if (result.isConfirmed) {

                    axios.delete('/monto-destino-delete/'+id).then(response => {
                        if (response.status == 200) {
                            this.$swal.fire(
                                '¡Eliminado!',
                                'El monto ha sido eliminado.',
                                'success'
                            )
                            this.getMontoDestino()
                        }
                    }).catch(error => {
                        console.log(error)
                    })

                }
            });
        }
    }
}
</script>

<style scoped>

</style>
