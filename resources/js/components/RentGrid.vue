<template>
    <div class="container">
        <div class="img-half-wrapper">
            <img :src="getPrimaryImage" class="listing-image" alt="listing image" />
        </div>
    </div>

</template>
<script setup>
import { ref, reactive, computed } from 'vue';

const props = defineProps({
    listing: {
        type: Object,
        required: true,
    },
});
const noImage = ref('');

const getPrimaryImage = computed(() => {
    if(props.listing.listing_images === null || props.listing.listing_images === undefined) {
        noImage.value = 'no images';
        return null;
    }
    return props.listing.listing_images.find(img => img.isPrimary) ?? props.listing.listing_images[0];

})
</script>
<style scoped>
.container {
    display: flex;
    width: 100%;
    height: 500px;
    flex-direction: row;
}
.img-half-wrapper {
    height: 100%;
    height: 40%;
    overflow: hidden;
}
.listing-img {
    height: 100%;
    width: 100%;
    object-fit: cover;
}
</style>
