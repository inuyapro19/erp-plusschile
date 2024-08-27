<template>
    <div class="card pt-5" :class="customClass">
        <div class="card-header" v-show="isHeader">
            <h3 class="card-title">{{ title }}</h3>
            <slot name="header"></slot>
        </div>
        <div class="card-body p-10">
            <slot name="body"></slot>
        </div>
        <!--end::Card body-->
        <div class="card-footer" v-show="isFooter">
            <slot name="footer"></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: "CardComponent",
    props: {
        isFooter: {
            type: Boolean,
            default: false,
        },
        title: {
            type: String,
            default: "",
        },
        customClass: {
            type: String,
            default: "",
        },
        isHeader:{
            type: Boolean,
            default: true,
        }
    },
}
</script>

<style scoped>

</style>
