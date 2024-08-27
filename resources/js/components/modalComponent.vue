<template>
    <div class="modal fade"  :id="id" tabindex="-1" role="dialog" @keydown.esc="closeModal">
        <div class="modal-dialog" :class="customClass" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">{{ title }}</h2>
                    <div id="modal_close" @click="closeModal"
                         class="btn btn-icon btn-sm btn-active-icon-primary" >
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
								    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
								</svg>
                            </span>
                        <!--end::Svg Icon-->
                    </div>
                </div>
                <div class="modal-body">
                    <slot name="body"></slot>
                </div>
                <div class="modal-footer">
                    <slot name="footer">
                        <button
                            v-if="hideCloseButton"
                            type="button"
                            class="btn btn-secondary"
                            @click="closeModal">Cerrar</button>
                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'BootstrapModal',
    props: {
        id: {
            type: String,
            required: true
        },
        title: {
            type: String,
            required: true
        },
        size: {
            type: String,
            default: ''
        },
        customClass: {
            type: String,
            default: ''
        },
        hideCloseButton: {
            type: Boolean,
            default: false
        },
        onCloseButton: {
            type: Function,
            default: () => {}
        }
    },
    methods: {
        closeModal() {
            this.onCloseButton();
        }
    }

}
</script>

