<template>
    <div class="container">
        <div class="img-wrapper">

        </div>

    </div>

</template>
<script setup>
import { ref, reactive, computed, onMounted } from 'vue';


const props = defineProps({
    listing: {
        type: Object,
        required: true,
    },
});

const primaryImageCheck = computed(() => {
    if(props.listing.listing.listing_images === null) return null;
    return props.listing.listing.listing_images.find(img => img.is_primary) ?? props.listing.listing_images[0];
})
</script>
<style scoped>
.container {
    display: flex;

}
.img-wrapper {
    display: flex;
    height: 100%;
    width: 100%;
}
</style>
