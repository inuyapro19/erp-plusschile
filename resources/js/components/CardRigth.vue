<template>
    <div
        id="kt_engage_demos"
        :class="['bg-body drawer drawer-end', { 'drawer-on': isActive }]"
        data-kt-drawer="true"
        data-kt-drawer-name="explore"
        data-kt-drawer-activate="true"
        data-kt-drawer-overlay="true"
        :data-kt-drawer-width="{default:'350px', 'lg': '475px'}"
        data-kt-drawer-direction="end"
        data-kt-drawer-toggle="#kt_engage_demos_toggle"
        data-kt-drawer-close="#kt_engage_demos_close"
        style="width: 475px;"
    >
        <div class="card shadow-none rounded-0 w-100">
            <div class="card-header">
                <h3 class="card-title fw-bold text-gray-700">{{ title }}</h3>
                <div class="card-toolbar">
                    <!-- Usar slot o método para renderizar botón de cerrar si existe -->
                    <slot name="renderClose">

                    </slot>

                </div>
            </div>
            <div class="card-body pt-2">
                <div class="me-n7 pe-7" data-scroll="true" data-height="400" data-mobile-height="300">
                    <!-- Contenido principal como slot -->
                    <slot name="body"></slot>
                </div>
            </div>
            <div class="card-footer">
                <!-- Usar slot o método para renderizar acciones si existe -->
                <slot name="renderActions" v-if="$slots.renderActions"></slot>
                <template v-if="renderActions">
                    <div v-html="renderActions()"></div>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CardRight',
    props: {
        title: {
            type: String,
            default: '',
        },
        isActive: {
            type: Boolean,
            default: false,
        },
        renderActions: {
            type: Function,
        },
        renderClose: {
            type: Function,
        }
    },

};
</script>

<style scoped>
/* Aquí tus estilos específicos del componente, si los hay */
</style>

