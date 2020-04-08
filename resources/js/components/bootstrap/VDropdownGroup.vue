<template>
    <div v-if="visible">
        <h6 class="dropdown-header" v-if="header !== undefined">{{ header }}</h6>
        <slot></slot>
        <div class="dropdown-divider" v-if="!latest"></div>
    </div>
</template>

<script>
    export default {
        name: "VDropdownGroup",

        data: function () {
            return {
                visible: true,
                latest: false,
            }
        },

        props: {
            header: {
                type: String
            }
        },

        mounted() {
            this.visible = this.$children.some(function (child) {
                if (child.visible !== undefined && child.visible)
                    return true;
            });
            let parentsChildren = this.$parent.$children;
            this.latest = parentsChildren[parentsChildren.length - 1] === this;
        }
    }
</script>

<style scoped>

</style>
