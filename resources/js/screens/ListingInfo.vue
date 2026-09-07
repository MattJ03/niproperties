<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="listing-card">
        <div class="img-wrapper">
            <img v-if="currentImage" :src="`/api/listings/listing-images/${currentImage.id}`" class="listing-img" alt="listing"/>
        </div>
            <button class="landlord-name-btn"> {{  landlord }}
            <span>> </span></button>
        </div>
    </div>
</template>
<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import Navbar from "../components/Navbar.vue";
import { useListingStore } from "../stores/ListingStore.js";
import { useRoute } from "vue-router";
import {storeToRefs} from "pinia";

const listingStore = useListingStore();
const route = useRoute();
const currentIndex = ref(0);

const { listing, landlord, error, loading } = storeToRefs(listingStore);



const currentImage = computed(() => {
    return listing.value?.listing_images?.[currentIndex.value] ?? null;
})

onMounted(async () => {
    await listingStore.showListing(route.params.listingId);
    const primaryIdx = listing.value?.listing_images?.findIndex(img => img.is_primary);
    currentIndex.value = primaryIdx > -1 ? primaryIdx : 0;


});
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
    justify-content: center;
   margin-top: 180px;
    background-color: #FFFFFF;
}
.listing-img {
    width: 700px;
    height: 100%;
    object-fit: cover;
}
.landlord-name-btn {
    display: flex;
    margin-left: 30px;
    justify-content: space-between;
    height: 60px;
    align-items: center;
    width: 300px;
    font-size: 18px;
    background-color: #FFFFFF;
    font-weight: bold;
}
</style>
