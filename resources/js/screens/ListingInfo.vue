<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="listing-card">
        <div class="img-wrapper">
            <img v-if="currentImage" :src="`/api/listings/listing-images/${currentImage.id}`" class="listing-img" alt="listing"/>
        </div>
            <button @click="currentLandlord = landlord; moveToLandlordsDetails(landlord)" class="landlord-name-btn"> {{  landlord.name }}
            <span>> </span>
            </button>
            <div class="listing-details-specifics">
                <span v-if="listing.price" class="price-text"> £{{ listing.price }}</span>
                <span v-if="listing.rent_per_month" class="rent-text"> £{{ listing.rent_per_month }}
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
.listing-details-specifics {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    margin-left: 30px;
    margin-top: 50px;
}
.listing-info {
    display: flex;
    flex-direction: row;
    gap: 50px;
}
.price-text {
    font-size: 40px;
}
.rent-text {
    font-size: 40px;
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
</style>
