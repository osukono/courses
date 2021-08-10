<template>
    <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" :data-bs-target="target"
            :disabled="disabled">
        {{ label }}
    </button>
</template>

<script>
export default {
    name: "VDropdownModal",

    props: {
        enabled: {
            default: true
        },
        label: {
            type: String
        },
        modal: {
            type: String
        }
    },

    computed: {
        target: function () {
            return '#' + this.modal;
        },

        disabled: function() {
            return !!this.enabled === false;
        }
    }
}
</script>

<style scoped>

</style>
