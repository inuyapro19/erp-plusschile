<template>
    <div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Usuario</th>
                    <th>Acción</th>
                    <th>Tabla</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="log in logs">
                    <td>{{ log.fecha }}</td>
                    <td>{{ log.user.name }}</td>
                    <td>{{ log.accion }}</td>
                    <td>{{ log.tabla }}</td>
                    <td>
                        <div>
                            <button class="btn btn-primary" @click="verLog(log.id)"><i class="fa fa-eye-dropper"></i></button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: "Index",
    data() {
        return {
            logs: [],
            isAdmin: false
        };
    },
    mounted() {
        this.getLogs();
    },
    methods: {
       async getLogs() {
           try {
               const {data , status} = await axios.get("/getLogSistema")
               if(status === 200) {
                   this.logs = data.data;
               }
           }catch (error) {
               console.log(error);
           }
        },
        verLog(id) {
            axios.get("/getLogSistema/" + id).then(response => {
                this.$swal({
                    title: "Log",
                    text: response.data.log,
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Aceptar"
                });
            });
        }



    }
}
</script>

<style scoped>
th{
    font-weight: bolder!important;
    color: #fff!important;
}
th a:hover{
    cursor: pointer;
    color: #222222!important;
}

thead tr th{
    background-color: #D3B560;
    color: white;
}

.remarcar{
    font-weight: bolder!important;
    color: #222222!important;
}
.bootstrap-select.btn-group .dropdown-toggle .filter-option{
    color: #222222!important;
    font-size: 10px!important;
}

</style>
