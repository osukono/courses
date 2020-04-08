<template>
    <button class="dropdown-item text-danger" type="button"
            data-toggle="confirmation"
            :data-btn-ok-label="btnOkLabel"
            :data-title="title"
            :data-form="form" v-if="isVisible">
        {{ label }}
    </button>
</template>

<script>
    export default {
        name: "VDropdownConfirmation",

        props: {
            visible: {
                default: true
            },
            label: {
                type: String
            },
            title: {
                type: String
            },
            btnOkLabel: {
                type: String
            },
            form: {
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
