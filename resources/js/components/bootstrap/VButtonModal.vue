<template>
    <button type="button" class="btn btn-info"
            data-bs-toggle="modal" :data-bs-target=modal :disabled="disabled">
        <slot name="label"></slot>
        <slot name="icon"></slot>
    </button>
</template>

<script>
export default {
    name: "VButtonModal",

    props: {
        enabled: {
            default: true
        },
        modal: {
            type: String
        }
    },

    computed: {
        disabled: function () {
            return !!this.enabled === false;
        }
    }
}
</script>

<style scoped>

</style>
