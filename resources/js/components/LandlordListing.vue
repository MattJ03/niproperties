<template>
    <div class="container">

    </div>

</template>
<script setup>
import { ref, reactive, computed } from 'vue';

const props = defineProps({
    listing: {
        type: Object,
        require: true,
    },
});


</script>
<style scoped>
.container {
    display: flex;
    width: 100%;
}
</style>
