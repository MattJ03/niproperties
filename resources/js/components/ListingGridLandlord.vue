<template>
    <div class="container">
        <div class="img-wrapper">
            <img :src="`/api/listings/listing-images/${primaryImage.id}`" alt="listing image" class="listing-img"/>
        </div>
        <div class="listing-details">
        <span class="address-line-1-text"> {{ props.listing.address_line_1 }}</span>
            <div class="town-postcode">
                <img :src="location" class="location-img" alt="location" />
                <span class="town-text"> {{ props.listing.town }}, </span>
                <span class="postcode-text"> {{ props.listing.postcode }}</span>
            </div>
            <span v-if="props.listing.price" class="price-text"> £ {{ props.listing.price }} </span>
            <span v-if="props.listing.rent_per_month" class="price-text"> £{{ props.listing.rent_per_month }} per month</span>
        </div>
        </div>
</template>
<script setup>
import { ref, reactive, computed } from 'vue';
import location from '../assets/location.png';

const noImage = ref('');
const props = defineProps({
    listing: {
        type: Object,
        required: true,
    },
});

const primaryImage = computed(() => {
    if(props.listing.listing_images === null || props.listing.listing_images === undefined) {
        noImage.value = 'no images found';
        return null;
    }
    return props.listing.listing_images.find(img => img.is_primary) ?? props.listing.listing_images[0];
})

</script>
<style scoped>
.container {
    display: flex;
    flex-direction: column;
    width: 100%;
    height: 250px;
    border: 1px solid #65676b;
    border-radius: 12px;
}
.img-wrapper {
    width: 100%;
    height: 45%;
    overflow: hidden;
}
.listing-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.address-line-1-text {
    font-size: 15px;
    color: #000000;
}
.listing-details {
    margin-top: 18px;
    margin-left: 15px;
}
.town-postcode {
    display: flex;
    gap: 2px;
    margin-top: 10px;
    flex-direction: row;
    text-wrap: nowrap;
    margin-bottom: 20px;
}
.location-img {
    height: 18px;
}
.town-text {
    color: #65676b;
}
.postcode-text {
    color: #65676b;
    margin-left: 4px;
}
.price-text {
    color: #000000;
    font-weight: bold;
    font-size: 18px;
}
</style>
