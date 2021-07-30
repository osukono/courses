<template>
<div>
    <span class="text-secondary mr-3">Chunks:</span>
    <h5 class="d-inline">
        <span class="badge rounded-pill bg-light text-secondary mr-2 px-2"
              v-for="part in parts">
            {{ part }}
        </span>
    </h5>
</div>
</template>

<script>
export default {
    name: "Splitter",

    data() {
        return {
            parts: undefined,
        };
    },

    props: {
        value: String,
    },


    created() {
        this.value = this.value.replaceAll('\[', '');
        this.value = this.value.replaceAll(']', '');

        this.parts = this.value.split(/(?<!-|(^| )(in|at|on(?! the | a | an )|of|to)|(^| )(my|our|his|its|their)|^the| the|^a| a|^an| an|\d+) /gi);

        this.parts = this.parts.filter(function (el) {
            return el != null;
        });
    },
}
</script>

<style scoped>

</style>
