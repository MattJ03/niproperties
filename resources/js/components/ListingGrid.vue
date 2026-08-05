<template>
    <div class="container">
        <div class="img-wrapper">
            <img v-if="primaryImage" :src="`/api/listings/listing-images/${primaryImage.id}`" class="listing-image" alt="listing image" />
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
    height: 18dvh;
    width: 15dvh;
    border: 1px solid #000000;
}
.img-wrapper {
    height: 100%;
    width: 100%;
}
.listing-img {
    width: 100%;
    height: 100%;
}
</style>
