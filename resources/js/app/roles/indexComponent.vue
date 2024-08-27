<template>
    <CardComponent :title="'Roles De Usuarios'">
            <template #body>
                <div class="row my-3">
                    <div class="col-md-12">
                        <button class="btn btn-sm btn-success" @click="abrirModel"><i class="fa fa-plus-circle"></i> Agregar</button>
                    </div>
                </div>


                <SimpleTable :columns="columns"
                             :data="roles"
                             :actions="true"
                             @edit="abrirModel"
                             @delete="eliminar_rol"
                           />

                <!-- Modal -->
                <BootstrapModal  :id="'createRolModel'"
                                 :title="'Agregar Rol'"
                                 :customClass="'modal-dialog-centered mw-850px'"
                                 :hideCloseButton="false"
                                 :onCloseButton="cerrarModal">
                    <template #body>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="fs-6 fw-semibold mb-2" for="name">Nombre Rol</label>
                                    <input type="text" v-model="name" name="name" id="name"  class="form-control">
                                </div>

                            </div>
                        </div>

<!--                        <div class="row mt-10">
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <th>#</th>
                                    <th>Permiso</th>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(permiso, index) in permisos">
                                        <td><input type="checkbox" v-model="permisos_select" :value="permiso.id"></td>
                                        <td>{{ permiso.name }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>-->

                        <div class="row mt-10">
                            <div class="col-md-12 form-group">
                                <label for="rol" class="form-label mb-10">Permisos</label>
                                <div class="row">
                                    <div class="col-4 mb-5" v-for="(permiso, index) in permisos" :key="permiso.id">
                                        <label>
                                            <input class="form-check-input" type="checkbox" :value="permiso.id" v-model="permisos_select">
                                            {{ permiso.name.toUpperCase()}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </template>
                    <template #footer>
                        <!-- Contenido del pie de página del modal -->
                        <button
                            type="button"
                            class="btn btn-primary btn-sm"
                            @click.prevent="agregarRoles()"
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
import SimpleTable from "@/components/simpleTable.vue";
import BootstrapModal from '@/components/modalComponent.vue'

export default {
    components: {
        CardComponent,
        SimpleTable,
        BootstrapModal
    },
    data() {
        return {
            roles:[],
            permisos:[],
            permisos_select:[],
            name:'',
            permiso_old:[],
            rol_id:0,
            columns: [
                {title: 'ID', field: 'id'},
                {title: 'ROL', field: 'name'},
            ],
        }
    },
    mounted() {
        this.getRoles()
        this.getPermisos()
    },
    methods: {
      async getRoles(){
       await axios.get('/getRoles').then((res)=>{
              this.roles = res.data
          }).catch((error)=>{
              console.log(error)
          })
      },
        async getPermisos(){
            await axios.get('/getPermisos').then((res)=>{
                this.permisos = res.data.data
            }).catch((error)=>{
                console.log(error)
            })
        },
        abrirModel(id = 0){
             this.name = ''
             this.permisos_select = []
            this.rol_id = 0
            if (id>0){
                  let rol =  this.roles.find((item)=> item.id === id)
                  this.rol_id = id
                  this.name = rol.name

                  if (rol.permissions.length > 0){
                      rol.permissions.forEach((item)=>{
                          this.permisos_select.push(item.id)
                      })
                  }

                  this.permiso_old = this.permisos_select
              }

            $('#createRolModel').modal('show')
        },
       async agregarRoles(){
           /* let formData = new FormData
            formData.append('name',this.name)
            formData.append('permisos',this.permisos_select)*/
           let url = ''
           let select_old = 0
           if (this.rol_id > 0){
                url = '/role/'+this.rol_id
                select_old = 1
           }else{
                url = '/role'
               select_old=0
           }

           await axios.post(url, {name:this.name,permisos:this.permisos_select,editar:select_old,permisos_old:this.permiso_old}).then((res)=>{
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: this.rol_id == 0 ? 'Rol creado exitosamente' : 'Rol editado exitosamente'
                })
                //this.getPermisos()

                 this.getRoles()
                $('#createRolModel').modal('hide')
            }).catch((error)=>{
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Error al crear el rol'
                })
            })
        },

        cerrarModal(){
            this.name = ''
            this.permisos_select = []
            this.rol_id = 0
            this.permiso_old = []
            $('#createRolModel').modal('hide')
        },

      async eliminar_rol(id){
        await axios.delete('/role/'+id).then(res=>{
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Rol eliminado exitosamente'
        })
            this.getRoles()
        }).catch(error=>{
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'Error al eliminar el rol'
            })
        })
      }
    },
}
</script>

<style scoped>

</style>
