<template>
    <button type="button" class="btn btn-info"
            data-toggle="modal" :data-target=modal v-if="isVisible">
        <slot name="label"></slot>
        <slot name="icon"></slot>
    </button>
</template>

<script>
    export default {
        name: "VButtonModal",

        props: {
            visible: {
                default: true
            },
            modal: {
                type: String
            }
        },

        computed: {
            isVisible: function () {
                return !!this.visible;
            }
        },
    }
</script>

<style scoped>

</style>
