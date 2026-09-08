<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="listing-card">

            <div class="img-wrapper">
                <img v-if="currentImage" :src="`/api/listings/listing-images/${currentImage.id}`" class="listing-img" alt="listing"/>
            </div>

            <div class="listing-card-body">

                <div class="listing-card-main">
                    <button @click="currentLandlord = landlord; moveToLandlordsDetails(landlord)" class="landlord-name-btn"> {{ landlord.name }}
                        <span class="arrow-beside-name">> </span>
                    </button>

                    <div v-if="listing.sale_status === 'open'" class="is_active-text">
                        <img :src="greenCircle" class="green-circle-img" alt="green circle"/>
                        <span>Active</span>
                    </div>
                    <div v-if="listing.sale_status === 'closed'" class="is_not_active-text">
                        <img :src="redCircle" class="red-circle-img" alt="red circle"/>
                        <span>Unavailable</span>
                    </div>

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
                        <img :src="redpin" class="pin-img" alt="red pin" />
                        <span class="address-line-1-text"> {{ listing.address_line_1 }},</span>
                        <span v-if="listing.address_line_2" class="address-line-1-text"> {{ listing.address_line_2 }},</span>
                        <span class="town-text"> {{ listing.town }}</span>
                    </div>
                </div>

                <div class="listing-card-side">
                    <div class="landlord-details-card">
                        <span class="listed-by-text">Listed by: </span>
                        <div class="landlord-details">
                            <div class="pfp-img-wrapper">
                                <img :src="profilePicture" class="profile-picture-img" alt="agent picture"/>
                            </div>
                            <span class="landlord-name-box"> {{ landlord.name }}</span>
                            <button class="contact-landlord"> Contact {{ landlord.name }}</button>
                        </div>
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
import redpin from '../assets/red_pin.png';
import greenCircle from '../assets/green_circle.png';
import redCircle from '../assets/red_circle.png';
import profilePicture from '../assets/agent.png';
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
    min-height: 200dvh;
}
.img-wrapper {
    width: 100%;
    height: 500px;
    aspect-ratio: 16 / 9;
    border-radius: 12px;
    overflow: hidden;
    position: relative;
}
.page-layout {
    display: flex;
    flex-direction: row;
}
.landlord-name {
    margin-top: 200px;
}

.listing-card {
    display: flex;
    flex-direction: column;
    min-height: 80dvh;
    width: 1200px;
    border: 1px solid #F2EFE6;
    margin-top: 180px;
    background-color: #FFFFFF;
    border-radius: 12px;
    overflow: hidden;
}
.listing-card-main {
    display: flex;
    flex-direction: column;
    flex: 1 1 auto;
}
.listing-img {
    width: 100%;
    height: 100%;

    object-fit: cover;
}
.listing-card-body {
    display: flex;
    flex-direction: row;
}
.is_active-text {
    display: flex;
    width: fit-content;
    align-items: center;
    gap: 5px;
    font-size: 16px;
    margin-left: 30px;
    margin-top: 20px;
    font-weight: bold;
    padding: 6px 6px;
    background-color: #F2EFE6;
    border-radius: 60px;
}
.is_not_active-text {
    display: flex;
    width: fit-content;
    align-items: center;
    gap: 5px;
    font-size: 16px;
    margin-left: 30px;
    margin-top: 20px;
    font-weight: bold;
    padding: 6px 6px;
    background-color: #F2EFE6;
    border-radius: 60px;
}
.green-circle-img {
    height: 16px;
}
.red-circle-img {
    height: 16px;
}
.landlord-name-btn {
    display: flex;
    margin-left: 30px;
    justify-content: space-between;
    height: 60px;
    align-items: center;
    width: 70%;
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
    width: 70%;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    margin-left: 30px;
    margin-top: 15px;
    margin-right: 30px;
}
.landlord-card {
    position: absolute;
    flex-direction: column;
    height: 300px;
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
.pin-img {
    height: 16px;
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
.listing-card-side {
    flex: 0 0 20%;
    padding: 20px;
    position: sticky;
    top: 20px;
    align-self: flex-start;
    width: 100%;
    margin-right: 20px;

}
.landlord-details-card {
    display: flex;
    flex-direction: column;
    height: 100%;
   border: 1px solid #D3D3D3;
    width: 100%;
    border-radius: 10px;
}
.listed-by-text {
    color: #88807b;
    margin-left: 15px;
    margin-top: 10px;
}
.landlord-details {
    display: flex;
    align-items: center;

    flex-direction: column;
}
.pfp-img-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    width: 100%;
}
.profile-picture-img {
    width: 55px;
    border-radius: 60px;
    background-color: #FDFBD4;
    padding: 12px 12px;
    height: 55px;
    cursor: pointer;
}
.landlord-name-box {
    font-size: 18px;
    margin-top: 10px;
    color: #88807b;
}
.contact-landlord {
    font-size: 16px;
    margin-top: 15px;
}
</style>
