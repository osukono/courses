<template>
    <h6 class="dropdown-header" v-show="header !== undefined">{{ header }}</h6>
    <slot></slot>
    <div class="dropdown-divider"></div>
</template>

<script>
export default {
    name: "VDropdownGroup",

    props: {
        header: {
            type: String
        }
    },
}
</script>

<style scoped>

</style>
