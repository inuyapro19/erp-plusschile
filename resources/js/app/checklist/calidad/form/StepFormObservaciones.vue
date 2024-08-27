<template>
    <div class="row">
        <div class="col-md-12">
            <label class="fs-6 fw-semibold mb-2" for="">Observaciones</label>
            <textarea
                v-model="observaciones"
                class="form-control form-control-solid">
            </textarea>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        observaciones: {
            type: String,
            required: true
        }
    }
}
</script>
