<template>
    <div class="col-md-11 mx-auto">
        <form @submit.prevent="cambiopassword">
            <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" v-model="contrasena" id="password" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="password_confirm">Confirmar Contraseña</label>
                        <input type="password" v-model="confirm_contrasena" id="password_confirm" class="form-control">
                    </div>
                </div>
            </div>
            <button class="btn btn-success">Editar</button>
        </form>

    </div>
</template>

<script>
export default {
    data() {
        return {
            contrasena: '',
            confirm_contrasena:'',
            respuesta:false,
            alerta:'',
            mensajes:'',
            errors:[],
            inputClass:'form-control mb-4',
            errorsClass:''
        }
    },
    methods: {
        cambiopassword:function () {
            let formData = new FormData()

            formData.append('password',this.contrasena)
            formData.append('confirm_password',this.confirm_contrasena)

            axios.post('/cambiar_contrasena',formData,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then( (res) => {
                this.respuesta = true
                this.alerta= 'alert-success'
                this.mensajes = 'Contraseña cambiada exitosamente'
                // form.respuesta = response.data.mensaje;
                this.contrasena = ''
                this.confirm_contrasena=''

                // this.reset_contacto()
            }).catch( (error) => {
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al enviar el formulario'
                this.errorsClass = 'form-control is-invalid';
                if (error.response.status === 403) {
                    this.mostarError = true
                    this.errors = error.response.data.errors || {};
                }
            })
        }
    },
}
</script>

<style scoped>

</style>
