<template>
    <button type="button" class="btn btn-info" :id="id"
            data-toggle="tooltip" :data-title="tooltip" v-on:click="onclick" v-if="isVisible">
        <slot></slot>
<!--        <slot name="icon"></slot>-->
<!--        <slot name="label"></slot>-->
    </button>
</template>

<script>
    export default {
        name: "VButton",

        props: {
            id: {
                type: String
            },
            visible: {
                default: true
            },
            tooltip: {
                type: String
            },
            route: {
                type: String
            },
            submit: {
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
                else if (this.submit !== undefined)
                    $(this.submit).submit();
            }
        }
    }
</script>

<style scoped>

</style>
