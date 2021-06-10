<template>
<div>
    <h5>
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
        console.log('mounted');
        this.value = this.value.replaceAll('\[', '');
        this.value = this.value.replaceAll(']', '');

        this.parts = this.value.split(/(?<!-|(^| )(in|at|on(?! the | a | an )|to)|(^| )(my|our|his|her|its|their|your)|^the| the|^a| a|^an| an|\d+) /gi);
    },
}
</script>

<style scoped>

</style>
