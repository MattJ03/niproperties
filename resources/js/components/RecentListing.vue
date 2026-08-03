<template>
    <div class="container">
        <div class="img-wrapper">
            <img  v-if="primaryImage" :src="`/api/listings/listing-images/${primaryImage.id}`" alt="listing image" class="listing-img"/>
            <div v-else class="no-image-placeholder">No Image Found</div>
        </div>
        <div class="listing-details-wrapper">
        <div class="listing-details">
            <span class="details-price"> {{ formatPrice(props.listing.price) }} </span>
            <span> {{ props.listing.address_line_1 }}</span>
            <span v-if="props.listing.address_line_2"> {{ props.listing.address_line_2 }}</span>
            <div class="small-info-wrapper">
                <div class="town-postcode-background">
            <span class="town-text"> {{ props.listing.town }}</span>
                </div>
                <div class="town-postcode-background">
                <span class="town-text"> {{ props.listing.postcode}}</span>
                </div>
                </div>
        </div>
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

const noImage = ref('');

const primaryImage = computed(() => {
    if(props.listing.listing_images === null) {
        noImage.value = 'No Image Found'
        return null;
    }

    return props.listing.listing_images.find(img => img.is_primary) ?? props.listing.listing_images[0];
});

function formatPrice(price) {
   return Intl.NumberFormat(
        'en-GB',
        { style: "currency",
                 currency: "GBP"},

    ).format(price);
}
</script>
<style scoped>
.container {
    display: flex;
    flex-direction: column;
    height: 48dvh;

    border-radius: 12px;
    border: 1px solid #000000;
    flex-direction: column;

}
.img-wrapper {
    display: flex;
    justify-content: center;
    height: 70%;
    width: 100%;
}
.listing-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 12px 12px 0px 0px;
}
.listing-details-wrapper {
    display: flex;
    justify-content: left;
    width: 100%;
    height: 30%;
    border-radius: 12px;
    background-color: #FDFBD4;
}
.listing-details {
    display: flex;
    gap: 10px;
    margin-left: 15px;
    margin-top: 15px;
    flex-direction: column;
    width: 100%;

}
.listing-details span {


}
.small-info-wrapper {
    display: flex;
    flex-direction: row;
    gap: 15px;
}
.town-text {

    color: #000000;
    font-size: 20px;
}
.town-postcode-background {
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #FFFFFF;
    height: fit-content;
    width: fit-content;
    border-radius: 14px;
    padding-left: 5px;
    padding-right: 5px;
    padding-top: 5px;
    padding-bottom: 5px;
}
.no-image-placeholder {
    height: 100px;
    width: 100px;
}
.details-price {
    font-size: 36px;
    color: #2d6e53;
}
</style>
