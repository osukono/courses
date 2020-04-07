<template>
    <button type="button" class="btn btn-info"
            data-toggle="tooltip" :data-title="tooltip" v-on:click="onclick" v-if="isVisible">
        <slot></slot>
    </button>
</template>

<script>
    export default {
        name: "ToolbarButton",

        props: {
            visible: {
                default: true
            },
            tooltip: {
                type: String
            },
            route: {
                type: String
            }
        },

        computed: {
            isVisible: function () {
                return !!this.visible;
            }
        },

        methods: {
            onclick: function () {
                if (this.route !== undefined)
                    document.location.href = this.route;
            }
        }
    }
</script>

<style scoped>

</style>
