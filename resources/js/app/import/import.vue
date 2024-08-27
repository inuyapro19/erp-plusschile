<template>
    <div class="widget-content widget-content-area">
        <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
        <form @submit.prevent="cargarDatos">
            <div class="form-group col-md-6">
                <label for="">Selecciones importador</label>
                <select name="" id="" v-model="tipo_importar" class="form-control">
                    <option value="">Seleccione</option>
                    <option value="1">Trabajadores</option>
                    <option value="2">Datos de contratactuales</option>
                    <option value="3">Datos de contactos</option>
                    <option value="4">Datos de afp</option>
                    <option value="5">Datos de salud</option>
                    <option value="6">Cargas Familiares</option>
                    <option value="7">Bancos</option>
                    <option value="8">Buses</option>
                    <option value="9">Gestión Tripulacion</option>
                    <option value="10">Vacaciones </option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="">Nuevo registro / Actualizar registros</label>
                <select name="tipo_carga" id="tipo_carga" v-model="tipo_carga" class="form-control">
                    <option value="">Seleccione</option>
                    <option value="1">Nuevo registros</option>
                    <option value="2">Actualizar Registros</option>
                </select>
            </div>
            <div class="form-group col-md-8">
                <input  name="excel" ref="file"  id="file-upload" class="form-control-file" type="file" aria-label="Adjunte su Reporte Anual" @change="onFileChange()" required   accept=".xlsx, .xls, .csv" />
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h4>Formatos de excel de subida</h4>

                </div>
            </div>

            <button type="submit" class="btn btn-success">Importar</button>
        </form>

    </div>
</template>

<script>
export default {
    data() {
        return {
            tipo_importar:'',
            tipo_carga:'',
            archivo:'',
            alerta:'',
            mensajes:'',
            inputClass:'form-control mb-4',
            errorsClass:'',
            respuesta:false,
            size:'',
            filename:''
        }
    },
    methods:{
       async cargarDatos (){
           try{
               let formData =  new FormData()
               formData.append('file',this.archivo)
               formData.append('tipo_importar',this.tipo_importar)
               formData.append('tipo_carga',this.tipo_carga)

             const {status} = await axios.post('/ficha-import-create',
                   formData,
                   {
                       headers: {
                           'Content-Type': 'multipart/form-data'
                       }
                   })
             if (status === 200){
                 this.tipo_importar = ''
                 this.tipo_carga = ''
                 this.archivo = ''
                 this.respuesta = true
                 this.alerta= 'alert-success'
                 this.mensajes = 'importacion exitosa'
                 this.$swal.fire({
                        title: 'Importacion exitosa',
                        text: 'Los datos se importaron correctamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    })

             }
           }catch (e) {
               this.respuesta = true
               this.alerta= 'alert-danger'
               this.mensajes = 'Error al importar'
               this.$swal.fire({
                     title: 'Error al importar',
                     text: 'Los datos no se importaron correctamente',
                     icon: 'error',
                     confirmButtonText: 'Aceptar'
                })

           }
     },
        onFileChange() {
            //console.log(e.target.files[0]);
            this.filename =   this.$refs.file.files[0].name;
            this.size =  this.file = this.$refs.file.files[0].size;
            this.archivo = this.$refs.file.files[0];
        }
    }

}
</script>

<style scoped>

</style>
