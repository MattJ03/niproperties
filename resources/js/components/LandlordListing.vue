<template>
    <div class="container">
        <div class="img-wrapper">
            <img :src="`/api/listings/listing-images/${primaryImage.id}`" class="listing-img" alt="listing image" />
        </div>

    </div>

</template>
<script setup>
import { ref, reactive, computed } from 'vue';


const noImage = ref('')
const props = defineProps({
    listing: {
        type: Object,
        require: true,
    },
});

const primaryImage = computed(() => {
    if(props.listing.listing_images === null || props.listing.listing_images === undefined) {
        noImage.value = 'no listing images';
        return null;
    }
    return props.listing.listing.listing_images.find(img => img.isPrimary) ?? props.listing.listing_images[0];
})

</script>
<style scoped>
.container {
    display: flex;
    width: 100%;
    height: 25dvh;
}
.img-wrapper {
    overflow: hidden;
    height: 40%;
    width: 100%;
}
.listing-img {
    object-fit: cover;
    width: 100%;
    height: 100%;
}
</style>
