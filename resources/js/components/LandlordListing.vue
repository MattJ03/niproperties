<template>
 <div class="listing-card">
     <div class="img-wrapper">
         <img :src="`/api/listings/listing-images/${primaryImage.id}`" class="listing-image" alt="listing image" />
     </div>
     <span v-if="props.listing.price" class="price-text"> £{{ props.listing.price }}</span>
     <div class="address-section">
         <span class="address-line-1"> {{ props.listing.address_line_1 }}</span>
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
    return props.listing.listing_images.find(img => img.isPrimary) ?? props.listing.listing_images[0];
})

</script>
<style scoped>
.listing-card {
    display: flex;
    flex-direction: column;
    background-color: #f3f4f6;
    width: 80%;
    height: 400px;
    border-radius: 12px;

}
.img-wrapper {
    overflow: hidden;
    height: 40%;
    width: 100%;
}
.listing-image {
    height: 100%;
    width: 100%;
    object-fit: cover;
    border-radius: 12px;
}
.address-section {
    display: flex;
    margin-left: 20px;
    margin-top: 10px;
}
.price-text {
    font-weight: bold;
    margin-top: 15px;
    margin-left: 20px;
    font-size: 22px;
}
.address-line-1 {
    font-weight: bold;
}
</style>
