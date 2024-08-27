<template>
    <div class="form-group mb-10">
        <label :for="name">{{ label }}</label>
        <input
            :id="name"
            :name="name"
            :type="type"
            class="'form-control form-control-solid'"
            :class="{'is-invalid': errors.has(name) }"
            :value="value"
            @input="updateValue"
            v-validate="validations"
            :data-vv-as="label"
        />
        <span class="invalid-feedback" v-show="errors.has(name)">
            {{ errors.first(name) }}
        </span>
    </div>
</template>

<script>
export default {
    props: {
        label: {
            type: String,
            required: true,
        },
        name: {
            type: String,
            required: true,
        },
        type: {
            type: String,
            default: 'text',
        },
        value: {
            type: [String, Number],
            default: '',
        },
        validations: {
            type: [String, Object],
            default: '',
        },
    },
    methods: {
        updateValue(event) {
            this.$emit('input', event.target.value);
        },
    },
};
</script>


