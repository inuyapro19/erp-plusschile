<template>
    <div>
        <CardComponent :title="'Checklist calidad'">

            <template #header>
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group mb-3">
                            <a href="/checklist-calidad/nuevo"  class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i> Agregar</a>
                        </div>
                    </div>
                </div>
            </template>

            <template #body v-show="loading">
<!--                <loading v-model:active="isLoading"
                         :can-cancel="true"
                         :is-full-page="fullPage"
                         :active="active"
                />-->
                <data-table :items="checklist" :loading="loading" :columns="columns">
                    <template #actions="{ item }">

                    </template>
                </data-table>
            </template>

        </CardComponent>
    </div>
</template>


<script>
import paginate from "../../../components/paginate.vue";
import BootstrapModal from "../../../components/modalComponent.vue";
import DataTable from "../../../components/DataTable.vue";
import Select2 from "../../../components/Form/Select2.vue";
import CardComponent from "../../../components/CardComponent.vue";
import Loading from "vue-loading-overlay";
 export default {
     components: {
         Loading,
         CardComponent,
         paginate,
         BootstrapModal,
         DataTable,
         Select2
     },
    data() {
        return {
            columns:[
                { key: 'CHECKLIST_ID', label: 'ID',sortable:true },
                { key: 'CATEGORIA', label: 'Categoria',sortable:true },
                { key: 'NRO_BUS', label: 'Nº Bus',sortable:true },
                { key: 'PATENTE', label: 'Patente',sortable:true },
                { key: 'NOMBRE_USUARIO', label: 'Ingresado por',sortable:true },
                { key: 'Folio', label: 'Folio',sortable:true },
                { key: 'FECHA_CREACION', label: 'Fecha',sortable:true },
                { key: 'STATUS', label: 'Estado',sortable:true },
            ],
            checklist: [],
            selectArray: [],
            color: "primary",
            loading: false,
            fullPage: true,
            isLoading: false,
            active: true,
        };
    },
    mounted() {
        this.getChecklist();
    },
    methods: {
        getChecklist() {
            //this.loading = true;
            axios
                .get("/getchecklistcalidad")
                .then((res) => {
                    this.checklist = res.data;
                    this.loading = false;
                })
                .catch((err) => {
                    console.log(err);
                });
        },


    },

};

</script>
