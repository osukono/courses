<template>
    <div class="btn-group" role="group" v-if="visible">
        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
            <slot name="icon"></slot>
            <slot name="label"></slot>
        </button>
        <div class="dropdown-menu dropdown-menu-right">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        name: "VDropdown",

        data: function() {
            return {
                visible: true
            }
        },

        mounted() {
            this.visible = this.$children.some(function (child) {
                // console.log(child);
                if (child.visible !== undefined && child.visible)
                    return true;
            });
        }
    }
</script>

<style scoped>

</style>
