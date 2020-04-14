<template>
    <button type="button" class="dropdown-item text-danger" data-toggle="modal" :data-target="target" v-show="visible">
        {{ label }}
    </button>
</template>

<script>
    export default {
        name: "VDropdownModal",

        props: {
            visible: {
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
            }
        }
    }
</script>

<style scoped>

</style>
