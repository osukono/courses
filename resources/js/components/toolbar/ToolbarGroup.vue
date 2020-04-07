<template>
    <div class="btn-group ml-2" role="group" v-if="isVisible">
        <slot></slot>
    </div>
</template>

<script>
    export default {
        name: "ToolbarGroup",

        props: {
            visible: {
                default: true
            }
        },

        computed: {
            isVisible: function () {
                return this.visible;
            }
        },

    }
</script>

<style scoped>

</style>
