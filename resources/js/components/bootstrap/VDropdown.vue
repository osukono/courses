<template>
    <div class="btn-group" role="group">
        <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown"
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
}
</script>

<style scoped>

</style>
