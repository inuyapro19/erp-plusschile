<template>
    <div class="row">
        <loading v-model:active="isLoading"
                 :can-cancel="true"
                 :is-full-page="fullPage"
                 :active="active"
        />
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <th>#</th>
                    <th>MES</th>
                    <th>Acciones</th>
                </thead>
                <tbody>
                    <tr v-for="mes in meses">
                        <td>{{mes.id}}</td>
                        <td>{{mes.nombre_mes}}</td>
                        <td>
                            <label class="switch s-icons s-outline s-outline-success  mr-2">
                                <input type="checkbox" id="meses_check" @change="cerrar_mes(mes.id, mes.isOpen)"  :checked="mes.isOpen === 'Y' ? true : false" >
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
export default {
    components:{
        Loading
    },
    data() {
        return {
            meses: [],
            isOpen:[],
            //loading
            isLoading: false,
            fullPage: true,
            active:true
        }
    },
    mounted() {
        this.getMeses()
    },
    methods:{
        async getMeses(){
            this.isLoading = true;
            // simulate AJAX
            setTimeout(() => {
                this.isLoading = false
                this.active = false
            }, 1000)
            await axios.get('/get-control-meses-renumerable').then((res)=>{
                this.meses = res.data
            }).catch((error)=>{
                console.log('error')
            })
        },
        async cerrar_mes(id,isOpen){
            console.log(id,isOpen)
            await axios.post('/control-meses-renumerable/'+id,{isOpen: isOpen}).then((res)=>{
                this.getMeses()
                this.$swal('El mes ha cambiado de estado')
            }).catch((error)=>{
                console.log(error)
            })
        }
    }
}
</script>

<style scoped>

</style>
