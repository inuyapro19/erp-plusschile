<template>
  <div>
      <div class="row mb-3">
          <div class="col-md-12">
              <button class="btn btn-success btn-sm" @click="OpenModal(0)">Agregar</button>
          </div>
      </div>
      <div class="row">
          <div class="col-md-12">
              <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                  <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th>ID</th>
                        <th>Descripcion</th>
                        <th>Valor</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody class="fw-semibold text-gray-600">
                   <tr v-for="(paramentro, index) in paramentros.data">
                       <td>{{paramentro.id}}</td>
                       <td>{{paramentro.descripcion}}</td>
                       <td>{{paramentro.valor}}</td>
                       <td>{{paramentro.tipo}}</td>
                       <td>
                           <button class="btn btn-sm btn-primary" @click="OpenModal(paramentro.id)"><i class="fa fa-edit"></i></button>
                       </td>
                   </tr>
                  </tbody>
              </table>
          </div>
      </div>

      <!-- AGREGAR BONOS -->
      <div class="modal  fade" id="AgregarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Parametro</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">


                          <div class="col-md-12">
                              <label for="">Descripción</label>
                              <input type="text" v-model="descripcion" id="rut" class="form-control">
                          </div>

                          <div class="col-md-12">
                              <label for="">Valor</label>
                              <input type="text" v-model="valor" id="monto" class="form-control">
                          </div>

                          <div class="col-md-12">
                              <label for="">Tipo</label>
                              <select  v-model="tipo" id="" class="form-control">
                                  <option v-for="tipo in tipos" :value="tipo">{{tipo}}</option>
                              </select>
                          </div>

                      </div>

                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                      <button type="button"  class="btn btn-primary btn-sm" @click.prevent="enviarFormulario()"> Guardar</button>

                  </div>
              </div>
          </div>
      </div>


  </div>
</template>

<script>
export default {
    data() {
        return {
            paramentros:[],
            tipos:['GRATIFICACION DEFINIDA','PREVIRED','TRAMOS FAMILIAR','SEGURO CENSANTIA TRABAJADOR','TRAMOS IMPUESTO'],
            tipo:'',
            descripcion:'',
            valor:0, // valor numerico
            id:0
        }
    },
    mounted() {
        this.getParametros()
    },
    methods:{
        async getParametros(){
            await axios.get('/getParamentrosRenumeracion').then((res)=>{

                this.paramentros = res.data

            }).catch(error=>{
                this.$swal('error al obtener los datos')
                console.log('error')
            })
        },
        OpenModal(id){
            if (id > 0)
            {
                //editar
               let paramentros = this.paramentros.data.find((item) => item.id === id)
               // console.log(paramentros)
                this.descripcion = paramentros.descripcion
                this.valor = paramentros.valor
                this.tipo = paramentros.tipo
                this.id = paramentros.id
            }

            $('#AgregarModal').modal('show')
        },
        eliminarMasivaModal(){

        },
        async enviarFormulario(){

            let url = ''

            if(this.id > 0)
            {
                 url = '/paramentros-remuneraciones/'+this.id
            }else{
                 url = '/paramentros-remuneraciones'
            }

            await axios.post(url,{
                descripcion:this.descripcion,
                valor:this.valor,
                tipo:this.tipo
            })
                .then((res)=>{
                this.$swal('Registro agregado exitosamente')
                this.getParametros()
                $('#AgregarModal').modal('hide')
            }).catch((error)=>{
                this.$swal('error al enviar formulario')
            })
        }

    }
}
</script>

<style scoped>

</style>
