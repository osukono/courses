<template>
    <div class="btn-group" role="group">
        <button class="btn btn-info dropdown-toggle" type="button" id="more" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
            <icon-more-vertical></icon-more-vertical>
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="more">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ToolbarMore",
    }
</script>

<style scoped>

</style>
