<template>
    <button type="button" class="dropdown-item" v-on:click="onclick" :disabled="disabled">
        {{ label }}
    </button>
</template>

<script>
export default {
    name: "VDropdownItem",

    props: {
        enabled: {
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

    computed: {
        disabled: function () {
            return !!this.enabled === false;
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
