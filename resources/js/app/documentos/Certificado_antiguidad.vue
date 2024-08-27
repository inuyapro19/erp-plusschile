<template>
<div>
    <form @submit.prevent="agregarDocumento()" v-show="create">
        <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
        <div class="col-md-12 form-group">
            <label for="nombre_documento">Nombre Documento</label>
            <!--- <textarea name="editorData" id="editorData" class="form-control" v-model="editorData" cols="30" rows="10"></textarea>-->
            <input type="text" v-model="nombre_documento" id="nombre_documento" class="form-control">
        </div>
        <div class="col-md-12 form-group">
            <label>Documento</label>
           <!--- <textarea name="editorData" id="editorData" class="form-control" v-model="editorData" cols="30" rows="10"></textarea>-->
            <ckeditor v-model="editorData" :config="editorConfig"></ckeditor>
        </div>
        <div class="col-md-6 form-group">
            <label for="tipo_documento">Tipo Documento</label>
            <select name="tipo_documento" class="form-control" v-model="tipo_documento" id="tipo_documento">
                <option value="">--------Tipo Documento---------</option>
                <option value="certificado antiguidad">Certificado de Antiguidad</option>
                <option value="certificado vacaciones">Certificado de Vacaciones</option>
            </select>
        </div>
        <button class="btn btn-success btn-sm" type="submit">Guardar</button>
        <a href="/documentos" class="btn btn-default btn-sm">Volver</a>
    </form>

    <form @submit.prevent="editarDocumento()" v-show="edit">
        <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
        <div class="col-md-12 form-group">
            <label for="nombre_documento1">Nombre Documento</label>
            <!--- <textarea name="editorData" id="editorData" class="form-control" v-model="editorData" cols="30" rows="10"></textarea>-->
            <input type="text" v-model="nombre_documento" id="nombre_documento1" class="form-control">
        </div>
        <div class="col-md-12 form-group">
            <label>Documento</label>
            <!--- <textarea name="editorData" id="editorData" class="form-control" v-model="editorData" cols="30" rows="10"></textarea>-->
            <ckeditor v-model="editorData" :config="editorConfig"></ckeditor>
        </div>
        <div class="col-md-6 form-group">
            <label for="tipo_documento1">Tipo Documento</label>
            <select name="tipo_documento" v-model="tipo_documento" class="form-control" id="tipo_documento1">
                <option value="">--------Tipo Documento---------</option>
                <option value="certificado antiguidad">Certificado de Antiguidad</option>
                <option value="certificado vacaciones">Certificado de Vacaciones</option>
            </select>
        </div>
        <button class="btn btn-success btn-sm" type="submit">Guardar</button>
        <a href="/documentos" class="btn btn-default btn-sm">Volver</a>
    </form>
</div>

</template>

<script>

export default {
    props:{
      documento:{
          type:Object,
          require:false
      },
        editar:{
            type:Boolean,
            require:false
        }
    },
    data() {
        return {
            nombre_documento:'',
            editorData: '',
            tipo_documento: '',
            respuesta: false,
            alerta: '',
            mensajes: '',
            errors: [],
            inputClass: 'form-control mb-4',
            errorsClass: '',
            editorConfig: {
                allowedContent: true
            },
            create:true,
            edit:false,
            id:0,
        }
    },
    mounted() {
        this.cargarDocumentoEdit()
    },
    methods: {
        agregarDocumento: function () {

            let formData = new FormData();
            formData.append('nombre_documento',this.nombre_documento);
            formData.append('texto', this.editorData);
            formData.append('tipo_documento', this.tipo_documento);

            axios.post('/documentos', formData,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((res) => {
                this.respuesta = true
                this.alerta = 'alert-success'
                this.mensajes = 'Documento Creado exitosamente'

            }).catch((error) => {
                this.respuesta = true
                this.alerta = 'alert-danger'
                this.mensajes = 'Error al enviar el formulario'

            })
        },
        cargarDocumentoEdit:function (){
           if(this.editar){
               this.edit = true
               this.create = false
               this.nombre_documento = this.documento.nombre_documento
               this.editorData = this.documento.texto
               this.tipo_documento= this.documento.tipo_documento
               this.id = this.documento.id
           }
        },
        editarDocumento:function (){
            let id = this.id
            let formData = new FormData();
            formData.append('nombre_documento',this.nombre_documento);
            formData.append('texto', this.editorData);
            formData.append('tipo_documento', this.tipo_documento);

            axios.post('/documentos/'+id, formData,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((res) => {
                this.respuesta = true
                this.alerta = 'alert-success'
                this.mensajes = 'Documento Creado exitosamente'

            }).catch((error) => {
                this.respuesta = true
                this.alerta = 'alert-danger'
                this.mensajes = 'Error al enviar el formulario'
            })
        }
    }
}
</script>

<style scoped>

</style>
