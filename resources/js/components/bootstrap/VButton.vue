<template>
    <button type="button" class="btn btn-info" :id="id"
            data-bs-toggle="tooltip" :title="tooltip" v-on:click="onclick" :disabled="disabled">
        <slot></slot>
    </button>
</template>

<script>
export default {
    name: "VButton",

    props: {
        id: {
            type: String
        },
        enabled: {
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
        disabled: function () {
            return !!this.enabled === false;
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
