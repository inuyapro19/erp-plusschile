<template>
    <div>
        <form @submit.prevent="enviar_formulario">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="codigo_bus"></label>
                    <input type="text" id="codigo_bus" v-model="codigo_bus">
                </div>
            </div>

            <button class="btn btn-success" type="submit">Guardar</button>
            <a href="" class="btn btn-default"></a>
        </form>
    </div>
</template>

<script>

/*
* Se genera un codigo de tripulacion
* se asigna el bus a la tripulacion
* se asignan los trabajadores a la tripulacion con el cargo relacionado a buses (CHOFERES , AUXILIARES DE BUSES ETC)
* un trabajador no debes ser asignado dos veces a una distintas tripulaciones
* */

export default {
    data() {
        return {
            codigo_bus:'',
            buses_id:'',
            rut:'',
            tripulacion: [],
            buses:[],
            trabajadores:[]
        }
    },
    methods: {
        getBuses:function (){
            axios.get('/getBuses').then((res)=>{
                this.buses = res.data
            }).catch((error)=>{
                console.log('error')
            })
        },
        buscar_bus:function (codigo,patente){

        }
    },
}
</script>

<style scoped>

</style>
