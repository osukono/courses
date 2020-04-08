<template>
    <div class="btn-group ml-2" role="group" v-if="visible">
        <slot></slot>
    </div>
</template>

<script>
    export default {
        name: "ButtonGroup",

        data: function () {
            return {
                visible: true
            }
        },

        computed: {
            isVisible: function () {
                return this.visible;
            }
        },

        mounted() {
            this.visible = this.$children.some(function (child) {
                if (child.visible !== undefined && child.visible)
                    return true;
            });
        }
    }
</script>

<style scoped>

</style>
