<template>
    <div class="container">
        <div class="img-wrapper">
            <img v-if="primaryImage" :src="`/api/listings/listing-images/${primaryImage.id}`" class="listing-img" alt="listing image" />
        </div>
        <span> {{ props.listing.price}}</span>

    </div>

</template>
<script setup>
import { ref, reactive, computed } from 'vue';

const noImage = ref('');
const props = defineProps({
    listing: {
        type: Object,
        required: true,
    },
});

const primaryImage = computed(() => {
    console.log('method running');
    if(props.listing.listing_images === null || props.listing.listing_images === undefined){
        noImage.value = 'no image found'
        return null;
    }
    return props.listing.listing_images.find(img => img.is_primary) ?? props.listing.listing_images[0];
});


</script>
<style scoped>
.container {
    display: flex;
    flex-direction: column;
    width: 100%;

}
.img-wrapper {
    width: 100%;
    height: 200px;
    overflow: hidden;
}
.listing-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>
