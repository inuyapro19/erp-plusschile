<template>
<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
        <thead>
            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th>ID</th>
                <th>Nombre Documento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody class="fw-semibold text-gray-600">
            <tr v-for="(documento, index) in documentos">
                <td>{{documento.id}}</td>
                <td>{{documento.nombre_documento}}</td>
                <td>
                    <a :href="'/documentos/'+documento.id" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                    <a v-if="documento.tipo_documento === 'certificado antiguidad'" href="/generar-certificado-antiguidad/501" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a>
                    <a v-if="documento.tipo_documento === 'certificado vacaciones'" href="/comprobante-vacaciones-preview" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a>
                    <button class="btn btn-danger btn-sm" @click.prevent="eliminarDocumento(documento.id)"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</template>

<script>

export default {
    data() {
        return {
            documentos:[]
        }
    },
    mounted() {
     this.cargaDocumentos()
    },
    methods: {
      cargaDocumentos:function (){
          axios.get('/getdocumentos').then((res)=>{
              this.documentos = res.data
          }).catch((error)=>{
              console.log(error)
          })
      },
        eliminarDocumento:function(id){
          axios.delete('/documentos/'+id).then((res)=>{
                this.cargaDocumentos()
          }).catch((error)=>{

          })
        }
    },
}
</script>

<style scoped>

</style>
