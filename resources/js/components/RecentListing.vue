<template xmlns="http://www.w3.org/1999/html">
    <div class="container">
        <div class="img-wrapper">
            <img  v-if="primaryImage" :src="`/api/listings/listing-images/${primaryImage.id}`" alt="listing image" class="listing-img"/>
            <div v-else class="no-image-placeholder">No Image Found</div>
        </div>
        <div class="listing-details-wrapper">
        <div class="listing-details">
            <span v-if="props.listing.price" class="details-price"> {{ formatPrice(props.listing.price) }} </span>
            <span v-if="props.listing.rent_per_month" class="details-price"> {{ formatPrice(props.listing.rent_per_month) }} per month </span>
            <span> {{ props.listing.address_line_1 }}</span>
            <span v-if="props.listing.address_line_2" class="address-text"> {{ props.listing.address_line_2 }}</span>
            <div class="small-info-wrapper">
                <div class="town-postcode-wrapper">
              <span class="town-text"> {{ props.listing.town }}</span>
                    <span class="town-text"> {{ props.listing.postcode }}</span>
                </div>
                <button @click="selectedListing = props.listing; moveToListingInfo()" class="view-btn">View</button>
                </div>

        </div>
        </div>

    </div>

</template>
<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import router from '../router/index.js';
import { useListingStore } from "../stores/ListingStore.js";

const props = defineProps({
    listing: {
        type: Object,
        required: true,
    },
});
const selectedListing = ref(null);
const error = ref('');
const loading = ref(false);
const noImage = ref('');
const listingStore = useListingStore();


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

const moveToListingInfo = async () => {
    loading.value = true;
    listingStore.listing = selectedListing.value;
    try {
        await router.push({
            name: 'listing info',
            params: { listingId: selectedListing.value.id },
        });
    } catch(err) {
        error.value = error.response?.data?.message || 'failed to move to listing info';
        console.log(error.value);
    } finally {
        loading.value = false;
    }
}
</script>
<style scoped>
.container {
    display: flex;
    flex-direction: column;
    height: 49dvh;
    border-radius: 12px;
    border: 1px solid #000000;
    cursor: pointer;

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
    padding-bottom: 15px;
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
.address-text {
    font-size: 16px;
}
.town-postcode-wrapper {
    display: flex;
    flex-direction: row;
    gap: 15px;
    margin-top: 15px;
    width: 100%;
}
.small-info-wrapper {
    display: flex;


    flex-direction: row;
    gap: 15px;
    padding-bottom: 15px;
}
.town-text {

    color: #000000;
    font-size: 16px;
   padding: 8px 8px;
    background-color: #FFFFFF;
    border-radius: 80px;
}
.town-postcode-background {
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #FFFFFF;
    height: fit-content;
    width: fit-content;
    border-radius: 14px;
    padding-left: 8px;
    padding-right: 8px;
    padding-top: 8px;
    padding-bottom: 8px;
}
.no-image-placeholder {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: auto;
    height: 100px;
    width: 100px;
    font-size: 20px;
    border: 1px solid #000000;
    border-radius: 14px;
    padding: 8px 16px;
}
.details-price {
    font-size: 36px;
    color: #2d6e53;
}
.view-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 120px;
    margin-right: 30px;
    border-radius: 12px;
    background-color: #2dcc95;
    cursor: pointer;
    border: 1px solid #FFFFFF;
    color: #FFFFFF;
    font-size: 18px;

}
.view-btn:hover {
    background-color: #2d6e53;
}
</style>
