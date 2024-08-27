<!-- TabsContainer.vue -->
<template>
    <div>
        <ul class="nav nav-tabs mb-3 mt-3" role="tablist">
            <!-- Slots para las pestañas -->
            <slot name="tabs"></slot>
        </ul>
        <div class="tab-content">
            <!-- Slots para el contenido de cada pestaña -->
            <slot name="tab-content"></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: 'TabsContainer',
    // Aquí puedes agregar lógica adicional si es necesario
}
</script>

<style>
/* Estilos del componente */
</style>

<!--
para usar en los componentes que se quieran usar como tabs
<template>
  <div v-show="isActive" class="tab-pane" :class="{ active: isActive }">

  </div>
</template>

<script>
export default {
  name: 'Tab',
  props: {
    title: { type: String, required: true }
  },
  data() {
    return {
      isActive: false
    }
  },
  mounted() {
    this.isActive = this.$parent.tabs.length === 0;
  }
}
</script>

-->
