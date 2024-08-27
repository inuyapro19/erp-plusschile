<template>
     <div>
         <h1>Aqui van las siguiente configuraciones de notificaciones</h1>
     </div>
</template>

<script>
export default {
    name: "EditNotifications",
    data() {
        return {
            activar_notificaciones: false,
            activar_notificaciones_correo:false,
            trabajadores_roles:[],
            roles:[],
            notificacion_tiempo:'',

        }
    },
    mounted() {
    },
    methods: {

    },
}
</script>

<style scoped>

</style>
