<template>
    <div>
        <form @submit.prevent="agregarRoles()">
            <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
            <div class="alert alert-warning">*En contrucción</div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label for="name">Nombre Role</label>
                <input type="text" v-model="name" id="name" class="form-control">
            </div>
        </div>
            <h5>Permisos</h5>
            <table class="table table-bordered">
                <tr>
                    <td>Crear Trabajador</td>
                    <td><input type="checkbox" name="permiso_role" v-model="permisos_rol"></td>
                </tr>
                <tr>
                    <td>Editar Trabajador</td>
                    <td><input type="checkbox" name="permiso_role" v-model="permisos_rol"></td>
                </tr>
            </table>

            <button class="btn btn-success btn-sm" type="submit">Guardar</button>
            <a href="/roles-usuarios" class="btn btn-default btn-sm">Volver</a>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: '',
            permisos_rol:[],
            permisos:[],
            respuesta: false,
            alerta: '',
            mensajes: '',
            errors: [],
            inputClass: 'form-control mb-4',
            errorsClass: '',
        }
    },
    methods: {
        agregarRoles:function (){
            let formData = new FormData
            formData.append('name',this.name)

            axios.post('/role',formData,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((res)=>{
                this.respuesta = true
                this.alerta = 'alert-success'
                this.mensajes = 'Rol Creado exitosamente'
            }).catch((error)=>{
                this.respuesta = true
                this.alerta = 'alert-danger'
                this.mensajes = 'Error al enviar el formulario'
            })
        }
    },
}
</script>

<style scoped>

</style>
