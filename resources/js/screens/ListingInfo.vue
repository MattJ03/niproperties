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
                                <span class="field-answer"> {{ listing.beds }}</span>
                                <span class="field-topic">Beds</span>
                            </div>
                            <div class="field">
                                <span class="field-answer"> {{ listing.bathrooms }}</span>
                                <span class="field-topic">Bathrooms</span>
                            </div>
                        </div>
                    </div>

                    <div class="listing-address-area">
                        <img :src="redpin" class="pin-img" alt="red pin" />
                        <span class="address-line-1-text"> {{ listing.address_line_1 }},</span>
                        <span v-if="listing.address_line_2" class="address-line-1-text"> {{ listing.address_line_2 }},</span>
                        <span class="town-text"> {{ listing.town }}</span>
                    </div>
                    <div class="horizontal-line-above-description"></div>
                    <div class="description-section">
                        <h2 class="description-header">A brief description on the property</h2>
                        <p v-if="listing.description" class="description-text"> {{ listing.description }}</p>
                        <span v-if="!listing.description" class="no-description">No description provided</span>
                        <div class="horizontal-line-above-description"></div>
                    </div>
                    <div class="listing-stats">
                        <div class="data-point">
                            <span>County: </span>
                            <span class="data-point-answer"> {{ listing.county }}</span>
                        </div>
                        <div class="data-point">
                            <span>Views: </span>
                            <span class="data-point-answer"> {{ listing.views }}</span>
                        </div>
                        <div class="data-point">
                            <span>Uploaded: </span>
                            <span class="data-point-answer"> {{ dayjs(listing.created_at).format('DD/MMMM/YYYY')}}</span>
                        </div>
                    </div>
                    <div class="street-view-section">
                        <h2 class="street-view-header">Street view of property</h2>
                        <iframe
                        width="400px"
                        height="400"
                        frameborder="0" style="border: 0"
                        referrerpolicy="origin-when-cross-origin"
                        :src="`${streetViewUrl}`"
                        allowfullscreen
                        ></iframe>
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
                            <button @click="showModal = true;" class="contact-landlord"> Contact {{ landlord.name }}</button>
                        </div>
                    </div>
                    <div class="purchase-card">
                        <button>
                            <img :src="cart" alt="cart"/>
                            <span>Purchase</span>
                        </button>

                    </div>
                </div>
            </div>

        </div>
        </div>
    <div v-if="showModal === true" class="modal-overlay">
        <div class="contact-info-square">
            <div class="top-of-modal">
                <div class="header-contact-wrapper">
                <h2 class="contact-info-header">Contact info</h2>
                </div>
                <div @click="showModal = false;" class="close-modal-wrapper">
                    <img :src="x" class="close-btn" alt="close"/>
                </div>
            </div>
            <div class="contact-details">
                <div class="field">
                    <span class="field-text">Name:</span>
                    <span class="field-answer"> {{ landlord.name }}</span>
                </div>
                <div class="field">
                    <span class="field-text">Email:</span>
                    <span class="field-answer"> {{ landlord.email }}</span>
                    <img v-if="isEmailCopied === false" :src="copy" @click="copyEmail()" class="copy-img" id="copy" alt="copy"/>
                    <img v-if="isEmailCopied === true" :src="tick" class="copy-img" alt="tick" />
                </div>
                <div class="field">
                    <span class="field-text">Phone number:</span>
                    <span class="field-answer"> {{ landlord.contact }}</span>
                    <img v-if="isNumberCopied === false" :src="copy" @click="copyNumber()" class="copy-img" id="copy" alt="copy"/>
                    <img v-if="isNumberCopied === true" :src="tick" class="copy-img" alt="tick" />
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
import cart from '../assets/cart.png';
import dayjs from "dayjs";
import RelativeTime from 'dayjs/plugin/relativeTime.js';
import x from '../assets/x.png';
import copy from '../assets/copy.png';
import tick from '../assets/greenTick.png';


const listingStore = useListingStore();

const route = useRoute();
const currentIndex = ref(0);
const currentLandlord = ref(null);
const showModal = ref(false);
const isEmailCopied = ref(false);
const isNumberCopied = ref(false);
dayjs.extend(RelativeTime);

const { listing, landlord, error, loading } = storeToRefs(listingStore);

const currentImage = computed(() => {
    return listing.value?.listing_images?.[currentIndex.value] ?? null;
});

const streetViewKey = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;
const streetViewUrl = computed(() => {
    if (!listing.value?.latitude || !listing.value?.longitude) return '';
    return `https://www.google.com/maps/embed/v1/streetview?key=${streetViewKey}&location=${listing.value.latitude},${listing.value.longitude}&heading=210&pitch=5&fov=90`;
});

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
        console.error('Navigation failed:', err); //
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

const copyEmail = async () => {
    loading.value = true;
    try {
       await navigator.clipboard.writeText(landlord.value.email);
       changeSrc();
    } catch(err) {
        error.value = error.response?.data?.message || 'failed to copy to clipboard';
        console.log(error.value);
    } finally {
        loading.value = false;
    }
}
const copyNumber = async () => {
    loading.value = true;
    try {
        await navigator.clipboard.writeText(landlord.value.contact);
        changeSrcNumber();
    } catch(err) {
        error.value = error.response?.data?.message || 'failed to copy landlord number';
    } finally {
        loading.value = false;
    }
}

function changeSrc() {
    isEmailCopied.value = true;
    setTimeout(() => {
        isEmailCopied.value = false;
    }, 5000);
}

function changeSrcNumber() {
    isNumberCopied.value = true;
    setTimeout(() => {
        isNumberCopied.value = false;
    }, 5000);
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
    height: 150dvh;
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
    flex: 2 1 auto;
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
    border: 1px solid #D3D3D3;
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
    height: 230px;
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
    display: flex;
    align-items: center;
    font-size: 18px;
    margin-top: 25px;
    padding: 10px 8px;
    border-radius: 6px;
    color: #FFFFFF;
    background-color: #2dcc95;
    cursor: pointer;
    border: 1px solid #2dcc95;
    margin-bottom: 20px;
}
.purchase-card {
    display: flex;
    justify-content: center;
    align-items: center;
    border: 1px solid #D3D3D3;
    height: 80px;
    margin-top: 30px;
    border-radius: 8px;
}
.purchase-card button {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #006AFF;
    height: 55%;
    width: 85%;
    gap: 6px;
    border-radius: 8px;
    border: none;
    font-size: 18px;
    color: #FFFFFF;
    font-weight: bold;
    cursor: pointer;
}
.purchase-card img {
    height: 18px;
}
.purchase-card button:hover {
    background-color: #006affcc;
}
.horizontal-line-above-description {
    border-top: 1px solid #D3D3D3;
    width: 100%;
    margin-top: 30px;
}
.description-section {
    display: flex;
    flex-direction: column;
    margin-left: 30px;
}
.description-header {
    font-size: 26px;
}
.description-text {
    font-size: 18px;
}
.no-description {
    font-size: 24px;
    font-weight: bold;
}
.listing-stats {
    display: flex;
    align-items: center;
    gap: 25px;
    margin-top: 30px;
    flex-direction: row;
    margin-left: 30px;
}
.data-point {
    font-size: 17px;
    background-color: #2dcc95;
    padding: 5px 8px;
    border-radius: 60px;
    font-weight: bold;
    color: #FFFFFF;
}
.data-point-answer {
    font-size: 17px;
    color: #000000;
}
.street-view-section {
    display: flex;
    flex-direction: column;
    margin-top: 30px;
    margin-left: 30px;
    gap: 20px;
}
.street-view-header {

}
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    background-color: rgba(0,0,0,0.6);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    width: 100vw;
    overflow: hidden;

}
.contact-info-square {
    display: flex;
    flex-direction: column;
    width: 700px;
    height: 600px;
    border-radius: 12px;
    background-color: #F2EFE6;
}
.top-of-modal {
    display: flex;
    height: 10%;
    width: 100%;
    align-items: center;
    flex-direction: row;
}
.header-contact-wrapper {
    display: flex;
    width: 100%;
    padding-top: 10px;
    justify-content: center;
}
.close-modal-wrapper {
    display: flex;
    padding-top: 10px;
    padding-right: 15px;
    justify-content: end;
    flex-direction: row;
}
.close-btn {
    height: 40px;
    cursor: pointer;
    padding: 8px 8px;
}
.close-btn:hover {
    background-color: #FDFBD4;
    border-radius: 60px;
}
.contact-details {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 90%;
    margin-top: 80px;
    flex-direction: column;
}
.field {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 10px;
    margin-top: 30px;
}
.field-text {
    font-weight: bold;
    font-size: 22px;
}
.field-answer {
    font-size: 22px;
}
.copy-img {
    height: 18px;
    margin-left: 24px;
    cursor: pointer;
}
</style>
