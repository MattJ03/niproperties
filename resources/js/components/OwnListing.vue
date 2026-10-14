<template>
    <div class="listing-card">
        <div class="img-wrapper">
            <img :src="`/api/listings/listing-images/${primaryImage.id}`" class="listing-image" alt="listing image" />
        </div>
        <span v-if="props.listing.price" class="price-text"> {{ formatPrice }} </span>
        <div v-if="props.listing.rent_per_month" class="rent-section">
            <span class="rent-text"> {{ formatPrice }}</span>
            <span class="rent-suffix">/month</span>
        </div>
        <div class="address-section">
            <span class="address-line-1"> {{ props.listing.address_line_1 }}</span>
            <span v-if="props.listing.address_line_2" class="address-line-2"> {{ props.listing.address_line_2 }}</span>
        </div>
        <div class="town-postcode-wrapper">
            <img :src="location" class="location-img" alt="location" />
            <span> {{ props.listing.county }},</span>
            <span> {{ props.listing.town }},</span>
            <span> {{ props.listing.postcode }}</span>
        </div>
        <div class="horizontal-line-below-address"></div>
        <div class="housing-info-wrapper">
            <div class="field-and-img">
                <img :src="rooms" class="room-img" alt="room"/>
                <span> {{ props.listing.no_of_rooms }} rooms</span>
            </div>
            <div class="field-and-img">
                <img :src="bed" class="bed-img" alt="bed"/>
                <span> {{ props.listing.beds }} beds</span>
            </div>
            <div class="field-and-img">
                <img :src="bathroom" class="bathroom-img" alt="bathroom"/>
                <span>  {{ props.listing.bathrooms }} Bathrooms</span>
            </div>
        </div>
        <div class="horizontal-line-below-address"></div>
        <p class="description-paragraph"> {{ props.listing.description }}</p>
        <div class="bottom-of-listing">
            <div class="landlord-info-wrapper">
                <span class="letter-of-name"> {{ firstLetterName }}</span>
                <div class="managed-by-wrapper">
                    <span class="managed-by-text">Managed by</span>
                    <span class="landlord-name"> {{ name }}</span>
                </div>
            </div>
            <div class="created-at-view-listing-wrapper">
                <span class="created-at-text">listed {{ dayjs(props.listing.created_at).from() }}</span>
                <button class="delete-btn" @click="deleteListing()">Delete</button>
                <button class="update-btn" @click="selectedListing = props.listing.id; updateModalAppear()">Update</button>
                <button class="view-btn" @click="selectedListing = props.listing; moveToListingInfo()">View</button>
            </div>
        </div>
    </div>
    <div v-if="showUpdateModal === true" class="modal-overlay">
        <div class="update-modal-square">
            <div class="top-of-modal">
            <span class="update-listing-title">Update listing</span>
                <img :src="x" class="close-modal" @click="showUpdateModal = false" alt="close"/>
            </div>
            <div class="horizontal-line"></div>
            <div class="listing-details">
                <div class="address-section">
                <div class="field">
                    <span class="listing-data">Address line 1</span>
                    <input type="text" class="address-input" v-model="formDraft.address_line_1" placeholder="36 Cromwell Road"/>
                </div>
                <div class="field">
                    <span class="listing-data">Address line 2</span>
                    <input type="text" class="address-input" v-model="formDraft.address_line_2"/>
                </div>
                </div>
                <div class="listing-location-info">
                    <div class="field">
                    <span class="listing-data">Town</span>
                    <input type="text" class="town-input" v-model="formDraft.town" placeholder="Belfast"/>
                    </div>
                    <div class="field">
                        <span class="listing-data">County</span>
                        <select class="county-dropdown" v-model="formDraft.county">
                        <option v-for="county in counties">{{ county }}</option>
                        </select>
                    </div>
                    <div class="field">
                        <span class="listing-data">Postcode</span>
                        <input type="text" class="town-input" v-model="formDraft.postcode" placeholder="BT7 1JW"/>
                    </div>
                </div>
                <div class="listing-location-info">
                    <div class="field">
                        <span class="listing-data">Rent or buy</span>
                        <div class="rent-or-buy-button-wrapper">
                            <button class="rent-select-btn" @click="formDraft.type = 'rent'; formDraft.price = '';"
                                    :class=" { active: formDraft.type === 'rent' }"
                            >Rent</button>
                            <button class="buy-select-btn" @click="formDraft.type = 'buy'; formDraft.rent_per_month = ''"
                                    :class=" { active: formDraft.type === 'buy' }"
                            >Buy</button>
                        </div>
                    </div>
                    <div class="field">
                        <span class="listing-data">No. of rooms</span>
                        <input type="number" class="town-input" v-model="formDraft.no_of_rooms" placeholder="6"/>
                    </div>
                    <div class="field">
                        <span v-if="formDraft.type === 'rent'" class="listng-data">Rent per month (£)</span>
                        <input v-if="formDraft.type === 'rent'" type="number" class="town-input" placeholder="£"/>
                        <span v-if="formDraft.type === 'buy'" class="listing-data">Price (£)</span>
                        <input v-if="formDraft.type === 'buy'" type="number" class="town-input" placeholder="£"/>
                    </div>
                </div>
                <div class="listing-location-info">
                    <div class="field">
                        <span class="listing-data">Property type</span>
                        <div class="pill-selection">
                            <button class="residential-btn" @click="formDraft.is_commercial = false"
                            :class="{ active: formDraft.is_commercial == false }"
                            >Residential</button>
                            <button class="commericial-btn" @click="formDraft.is_commercial = true"
                            :class="{ active: formDraft.is_commercial == true }"
                            >Commercial</button>
                        </div>
                    </div>
                    <div class="field">
                        <span class="listing-data">Number of beds</span>
                        <input type="number" class="town-input" v-model="formDraft.beds" placeholder="3"/>
                    </div>
                    <div class="field">
                        <span class="listing-data">Number of bathrooms</span>
                        <input type="number" class="town-input" v-model="formDraft.bathrooms" placeholder="2"/>
                    </div>
                </div>
                <div class="listing-location-info">
                    <div class="description-field">
                        <span class="listing-data">Short description about the property</span>
                        <textarea class="description-text" v-model="formDraft.description"></textarea>
                    </div>
                </div>
                <div class="update-btn-wrapper">
                <button class="update-listing-btn" @click="updateListing()">Update</button>
                </div>
            </div>
        </div>

    </div>

</template>
<script setup>
import { ref, reactive, computed, watch } from 'vue';
import location from '../assets/location.png';
import rooms from '../assets/rooms2.png';
import bed from '../assets/bed.png';
import bathroom from '../assets/bathroom.png';
import dayjs from "dayjs";
import RelativeTime from 'dayjs/plugin/relativeTime.js';
import router from '../router/index.js';
import { useListingStore } from "../stores/ListingStore.js";
import x from '../assets/x2.png';
import { storeToRefs } from "pinia";

dayjs.extend(RelativeTime);

const noImage = ref('')
const props = defineProps({
    listing: {
        type: Object,
        require: true,
    },
});
const loading = ref(false);
const error = ref('');
const listingStore = useListingStore();
const selectedListing = ref(null);
const name = ref(props.listing.landlord.name);
const primaryImage = computed(() => {
    if(props.listing.listing_images === null || props.listing.listing_images === undefined) {
        noImage.value = 'no listing images';
        return null;
    }
    return props.listing.listing_images.find(img => img.isPrimary) ?? props.listing.listing_images[0];
});

const firstLetterName = computed(() => {
    if(!name.value) {
        return '';
    }
    return name.value.charAt(0).toUpperCase();
});
const counties = ['Fermanagh', 'Antrim', 'Tyrone', 'Londonderry', 'Armagh', 'Down'];
const showUpdateModal = ref(false);
const { listing } = storeToRefs(listingStore);
const formDraft = ref({... listing.value});
console.log(formDraft.value.address_line_1);
watch(listing, (newValue) => {
   formDraft.value = {...newValue};
});

const formatPrice = computed(() => {
    if(props.listing.price) {
        console.log('running');
        return new Intl.NumberFormat('en-GB',
            {
                style: 'currency',
                currency: 'GBP',
            }).format(props.listing.price);
    }
    if(props.listing.rent_per_month) {
        return new Intl.NumberFormat('en-GB', {
            style: 'currency',
            currency: 'GBP',
        }).format(props.listing.rent_per_month);
    }
});


const moveToListingInfo = async () => {
    loading.value = true;
    listingStore.listing = selectedListing.value;
    try {
        await router.push({
            name: 'listing info',
            params: { listingId: selectedListing.value.id },
        });
    } catch (err) {
        error.value = error.response?.data?.message || 'failed to move to listing info';
    } finally {
        loading.value = false;
    }
}

const deleteListing = async () => {
    loading.value = true;
    try {
        await listingStore.deleteListing(props.listing.id);
        await listingStore.getLandlordsListings(props.listing.landlord.id);
    } catch(err) {
        error.value = error.response?.data?.message || 'failed to delete listing';
    } finally {
        loading.value = false;
    }
}

const updateModalAppear = async () => {
    loading.value = true;
    try {
        console.log(selectedListing.value);
        await listingStore.showListing(selectedListing.value);
        showUpdateModal.value = true;
    } catch (err) {
        error.value = error.response?.data?.message || 'failed to get listing info';
    }
}

    const updateListing = async () => {
        loading.value = true;
        try {
            await listingStore.updateListing(selectedListing.value, formDraft.value);
            await listingStore.getLandlordsListings(props.listing.landlord.id);
            showUpdateModal.value = false;
        } catch (err) {
            error.value = error.response?.data?.message || 'failed to get '
        } finally {
            loading.value = false;
        }
    }
</script>
<style scoped>
.listing-card {
    display: flex;
    flex-direction: column;
    background-color: #f3f4f6;
    width: 70%;
    height: 600px;
    max-width: 720px;
    border-radius: 12px;
    cursor: pointer;
}
.listing-card:hover {
    border: 1px solid #FF0000;
}
.img-wrapper {
    overflow: hidden;
    height: 100%;
    width: 100%;
    aspect-ratio: 16 / 9;
}
.listing-image {
    height: 100%;
    width: 100%;
    display: block;
    object-fit: cover;
    border-radius: 12px;
}
.address-section {
    display: flex;
    flex-direction: column;
    margin-left: 20px;
    font-size: 20px;
    margin-top: 10px;
    width: 100%;
}
.price-text {
    font-weight: bold;
    margin-top: 15px;
    margin-left: 20px;
    font-size: 26px;
}
.rent-text {
    font-weight: bold;
    margin-top: 15px;
    margin-left: 20px;
    font-size: 26px;
}
.rent-section {
    margin-top: 15px;


}
.rent-suffix {
    color: #65676b;
    margin-left: 3px;
}
.address-line-1 {
    font-weight: bold;
}
.horizontal-line-below-address {
    border-top: 1px solid #A9A9A9;
    width: 100%;
    margin-top: 20px;
}
.town-postcode-wrapper {
    display: flex;
    width: 100%;
    flex-direction: row;
    gap: 5px;
    color: #A9A9A9;
    margin-left: 20px;
    margin-top: 10px;
}
.town-postcode-wrapper span {
    font-size: 18px;
}
.location-img {
    height: 18px;
}
.housing-info-wrapper {
    display: flex;
    flex-direction: row;
    align-items: center;
    margin-left: 20px;
    gap: 30px;
    margin-top: 10px;
}
.housing-info-wrapper span {
    font-size: 18px;
    color: #808080;

}
.field-and-img {
    display: flex;
    align-items: center;
    gap: 5px;

}
.room-img {
    height: 20px;
    width: 20px;
}
.bed-img {
    height: 20px;
    width: 20px;
}
.bathroom-img {
    height: 20px;
    width: 20px;
}
.description-paragraph {
    margin-left: 20px;
    text-wrap: auto;
    color: #808080;
}
.bottom-of-listing {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
    margin-left: 20px;
    width: 100%;
    margin-bottom: 30px;

}
.landlord-info-wrapper {
    display: flex;

}
.letter-of-name {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    background-color: #000000;
    padding: 12px 18px;
    border-radius: 50%;
    color: #f3f4f6;
}
.managed-by-wrapper {
    display: flex;
    flex-direction: column;
    margin-left: 8px;
    padding-left: 2px;

}
.managed-by-text {
    font-size: 12px;
    color: #88807b;
}
.landlord-name {
    font-weight: bold;
    font-size: 16px;
}
.created-at-view-listing-wrapper {
    display: flex;
    align-items: center;
    justify-content: right;
}
.created-at-text {
    color: #88807b;
    margin-right: 20px;
}
.delete-btn {
    padding: 14px 24px;
    background-color: #FF4000;
    border-radius: 12px;
    margin-right: 12px;
    font-size: 16px;
    color: #f3f4f6;
    border: none;
}
.delete-btn:hover {
    background-color: #D43500;
    cursor: pointer;
}
.update-btn {
    padding: 14px 24px;
    background-color: #FFBF00;
    border-radius: 12px;
    margin-right: 12px;
    font-size: 16px;
    color: #f3f4f6;
    border: none;
}
.update-btn:hover {
    background-color: #BFFF00;
    cursor: pointer;
}
.view-btn {
    padding: 14px 24px;
    background-color: #2dcc95;
    border-radius: 12px;
    margin-right: 40px;
    font-size: 16px;
    color: #f3f4f6;
    border: none;
}
.view-btn:hover {
    cursor: pointer;
    background-color: #2d6e53;
}
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    width: 100vw;
    overflow: hidden;
    background-color: transparent;


}
.update-modal-square {
    display: flex;
    flex-direction: column;
    width: 55%;
    height: fit-content;
    background-color: #FFFFFF;
    border-radius: 10px;

}
.update-listing-title {
    font-size: 22px;
    padding: 20px 20px;
}
.horizontal-line {
    width: 100%;
    border-top: 1px solid #88807b;

}
.listing-details {
    display: flex;

    flex-direction: column;
    width: 100%;
    padding: 40px 20px;

}
.field {
    display: flex;
    flex-direction: column;
    font-size: 18px;
    gap: 3px;
}
.description-field {
    display: flex;
    width: 100%;
    flex-direction: column;
    font-size: 18px;
    padding-bottom: 16px;
    gap: 3px;
}
.address-section {
    display: flex;
    flex-direction: row;
    gap: 70px;
}
.address-input {
    width: 450px;
    height: 45px;
    border-radius: 12px;
    border: 1px solid #D3D3D3;
    font-size: 16px;
    padding-left: 6px;
}
.listing-location-info {
    display: flex;
    width: 100%;
    flex-direction: row;
    padding-top: 40px;
    padding-left: 20px;
    gap: 90px;

}
.town-input {
    height: 45px;
    border-radius: 12px;
    padding-left: 6px;
    border: 1px solid #D3D3D3;
    font-size: 16px;
}
.county-dropdown {
    width: 300px;
    height: 45px;
    border-radius: 12px;
    border: 1px solid #FFFFFF;
    font-size: 16px;
}
.rent-or-buy-button-wrapper {
    display: flex;
    height: 45px;
    width: 200px;
}
.rent-select-btn,
.buy-select-btn {
    width: 100px;
    border-radius: 14px;
    cursor: pointer;
    border: 1.5px solid #2d6e53;
    background-color: transparent;
    font-size: 15px;
    color: #2d6e53;
    font-weight: 500;
    transition: all 0.15s ease;
}

.rent-select-btn.active,
.buy-select-btn.active {
    background-color: #2d6e53;
    color: #FDFBD4;
    border-color: #2d6e53;
}
.pill-selection {
    display: flex;
    flex-direction: row;
    height: fit-content;
}
.residential-btn {
    padding: 14px 14px;
    border-radius: 14px;
    font-size: 16px;
    color: #2d6e53;
    background-color: #FFFFFF;
    border: 1px solid #2d6e53;
    cursor: pointer;
}
.residential-btn.active {
    background-color: #2d6e53;
    color: #FFFFFF;
}
.commericial-btn {
    padding: 14px 14px;
    border-radius: 14px;
    font-size: 16px;
    color: #2d6e53;
    background-color: #FFFFFF;
    border: 1px solid #2d6e53;
    cursor: pointer;
}
.commericial-btn.active {
    background-color: #2d6e53;
    color: #FFFFFF;
}
.description-text {
    width: 85%;
    background-color: #FFFFFF;
    border-radius: 14px;
    height: 130px;
    color: #000000;
    padding-left: 15px;
    padding-top: 5px;

    font-size: 16px;
}
.top-of-modal {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
}
.close-modal {
    height: 30px;
    padding: 8px 8px;
    border-radius: 16px;
}
.close-modal:hover {
    cursor: pointer;
    background-color: #cccccc;
}
.update-listing-btn {
    align-items: center;
    display: flex;
    justify-content: center;
    width: 145px;
    height: 45px;
    font-size: 16px;
    background-color: #FFBF00;
    border: 1px solid #FFFFFF;
    border-radius: 12px;
    color: #FFFFFF;
}
.update-listing-btn:hover {
    background-color: #BFFF00;
    cursor: pointer;
}
.update-btn-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
}
@media(max-width: 900px) {
    .listing-card {
        width: 100%;
        height: 500px;
    }
    .landlord-info-wrapper {
        margin-right: 60px;
    }
    .created-at-text {
        margin-right: 0px;
    }
    .bottom-of-listing {
        margin-top: 12px;
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
        z-index: 65;
    }
    .update-modal-square {
        display: flex;
        width: 80%;
        height: 500px;
        background-color: #FFFFFF;
    }
}
</style>
