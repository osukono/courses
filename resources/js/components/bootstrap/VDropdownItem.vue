<template>
    <button type="button" class="dropdown-item" v-on:click="onclick" v-show="visible">
        {{ label }}
    </button>
</template>

<script>
    export default {
        name: "VDropdownItem",

        props: {
            visible: {
                default: true
            },
            label: {
                type: String
            },
            route: {
                type: String
            },
            click: {
                type: String
            },
            submit: {
                type: String
            }
        },

        methods: {
            onclick: function () {
                if (this.route !== undefined)
                    document.location.href = this.route;
                else if (this.click !== undefined)
                    $(this.click).click();
                else if (this.submit !== undefined)
                    $(this.submit).submit();
            }
        }
    }
</script>

<style scoped>

</style>
