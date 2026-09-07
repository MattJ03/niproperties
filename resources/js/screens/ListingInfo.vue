<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="listing-card">
        <div class="img-wrapper">
            <img v-if="currentImage" :src="`/api/listings/listing-images/${currentImage.id}`" class="listing-img" alt="listing"/>
        </div>
            <button @click="currentLandlord = landlord; moveToLandlordsDetails(landlord)" class="landlord-name-btn"> {{  landlord.name }}
            <span class="arrow-beside-name">> </span>
            </button>
            <div class="listing-details-specifics">
                <span v-if="listing.price" class="price-text"> {{ formatPrice(listing.price) }}</span>
                <span v-if="listing.rent_per_month" class="rent-text"> {{ formatPrice(listing.rent_per_month) }}
                <span class="per-mont-text">per month</span></span>
            <div class="listing-info">
                <div class="field">
                <span class="field-answer"> {{ listing.no_of_rooms }}</span>
                    <span class="field-topic">Rooms</span>
                </div>
                <div class="field">
                    <span class="field-answer">To be added</span>
                    <span class="field-topic">Beds</span>
                </div>
                <div class="field">
                    <span class="field-answer">Sqft</span>
                    <span class="field-topic">To be added</span>
                </div>
            </div>
            </div>
            <div class="listing-address-area">
                <span class="address-line-1-text"> {{ listing.address_line_1 }},</span>
                <span v-if="listing.address_line_2" class="address-line-1-text"> {{ listing.address_line_2 }},</span>
                <span class="town-text"> {{ listing.town }}</span>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import Navbar from "../components/Navbar.vue";
import { useListingStore } from "../stores/ListingStore.js";
import { useRoute } from "vue-router";
import {storeToRefs} from "pinia";
import router from "../router/index.js";


const listingStore = useListingStore();
const route = useRoute();
const currentIndex = ref(0);
const currentLandlord = ref(null);

const { listing, landlord, error, loading } = storeToRefs(listingStore);

const currentImage = computed(() => {
    return listing.value?.listing_images?.[currentIndex.value] ?? null;
})

onMounted(async () => {
    await listingStore.showListing(route.params.listingId);
    const primaryIdx = listing.value?.listing_images?.findIndex(img => img.is_primary);
    currentIndex.value = primaryIdx > -1 ? primaryIdx : 0;

});

const moveToLandlordsDetails = async (landlordArg) => {
    loading.value = true;
    try {
        await router.push({
            name: 'landlords listings',
            params: { landlordId: landlordArg.id },
        });
    } catch(err) {
        console.error('Navigation failed:', err); // <-- add this
        error.value = err.response?.data?.message || 'failed to move to landlords listings';
    } finally {
        loading.value = false;
    }
}

function formatPrice(price) {
    return Intl.NumberFormat("en-GB", {
        style: "currency",
        currency: "GBP",
    }
    ).format(price);
}
</script>
<style scoped>
.container {
    display: flex;
    width: 100%;
    justify-content: center;

}
.img-wrapper {
    width: 100%;

    aspect-ratio: 16 / 9;
    border-radius: 12px;
    overflow: hidden;
    position: relative;
}
.listing-card {
    display: flex;
    flex-direction: column;
    height: 80dvh;
    border: 1px solid #F2EFE6;
   margin-top: 180px;
    background-color: #FFFFFF;
}
.listing-img {
    width: 1000px;
    height: 100%;
    object-fit: cover;
}
.landlord-name-btn {
    display: flex;
    margin-left: 30px;
    justify-content: space-between;
    height: 60px;
    align-items: center;
    width: 600px;
    font-size: 18px;
    background-color: #FFFFFF;
    font-weight: bold;
    border: 1px solid #2d6e53;
    padding-left: 30px;
    border-radius: 8px;
}
.landlord-name-btn:hover {
    cursor: pointer;
}
.arrow-beside-name {
    padding-right: 16px;
}
.listing-details-specifics {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    margin-left: 30px;
    margin-top: 50px;
    margin-right: 30px;
}
.listing-info {
    display: flex;
    flex-direction: row;
    gap: 50px;
}
.price-text {
    font-size: 40px;
    font-weight: bold;
}
.rent-text {
    font-size: 40px;
    font-weight: bold;
}
.per-mont-text {
    font-size: 20px;
}
.field {
    display: flex;
    flex-direction: column;
    gap: 5px;
}
.field-answer {
    font-size: 30px;
    font-weight: bold;
}
.field-topic {
    font-size: 18px;
}
.listing-address-area {
    display: flex;
    align-items: center;
    flex-direction: row;
    margin-left: 30px;
    margin-top: 15px;
    font-size: 22px;
    color: #2d6e53;
    gap: 5px;
}
.address-line-1-text {
}
</style>
