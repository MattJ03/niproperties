<template>
    <div class="container">
        <div class="img-wrapper">
            <img v-if="primaryImage" :src="`/api/listings/listing-images/${primaryImage.id}`" class="listing-img" alt="listing image" />
        </div>
        <div class="listing-details">
            <strong><p v-if="props.listing.rent_per_month" class="price-listing"> £{{ props.listing.rent_per_month }} per month</p> </strong>
            <strong><span class="address-line-1-text">{{ props.listing.address_line_1}}</span></strong>
            <div class="postcode-town-wrapper">
                <img :src="location" alt="location pointer" class="location-img"/>
                <span class="town-text"> {{ props.listing.town }}, </span>
                <span class="town-text"> {{ props.listing.postcode }}</span>
            </div>
            <div class="house-information">
                <div class="topic-wrapper">
                    <img :src="rooms" alt="rooms" class="rooms-icon" />
                    <div class="num-and-info">
                        <strong><span class="rooms-info-text"> {{ props.listing.no_of_rooms }} </span></strong>
                        <span class="tiny-text-below-info">Rooms</span>
                    </div>
                </div>
                <img :src="pin" class="pin-icon" alt="pin"/>
                <div class="num-and-info">
                    <strong><span class="county-info-text"> {{ props.listing.county }}</span></strong>
                    <span class="tiny-text-below-info">County</span>
                </div>
            </div>
            <div v-if="props.listing.description" class="description-wrapper">
                <hr class="horizontal-line"/>
                <p class="description-text"> {{ props.listing.description}}</p>
            </div>
            <hr class="horizontal-line" />
            <div class="bottom-of-listing">

                <div class="listing-stats">
                    <img :src="logo" alt="niproperties logo" class="logo-img" />
                    <div class="sitename-time-uploaded">
                        <p class="niproperties-text">NI Properties</p>
                        <span class="time-since-upload"> {{ dayjs(props.listing.created_at).fromNow() }}</span>
                    </div>
                </div>
                <button class="view-btn" @click="selectedListing = props.listing; moveToListingInfo()">View</button>
            </div>
        </div>
    </div>

</template>
<script setup>
import { ref, reactive, computed } from 'vue';
import location from '../assets/location.png';
import rooms from '../assets/rooms.png';
import pin from '../assets/pin.png';
import logo from '../assets/nipropertieslogo.png';
import dayjs from "dayjs";
import relativeTime from 'dayjs/plugin/relativeTime.js';
import router from '../router/index.js';
import { useListingStore } from "../stores/ListingStore.js";
const noImage = ref('');
const props = defineProps({
    listing: {
        type: Object,
        required: true,
    },
});
const loading = ref(false);
const error = ref('');
const listingStore = useListingStore();
const currentPage = ref(1);
const nextPage = ref(currentPage + 1);
const selectedListing = ref(null);
const pageOneToFive = ref([1, 2, 3, 4, 5]);



dayjs.extend(relativeTime);

const primaryImage = computed(() => {
    console.log('method running');
    if(props.listing.listing_images === null || props.listing.listing_images === undefined){
        noImage.value = 'no image found'
        return null;
    }
    return props.listing.listing_images.find(img => img.is_primary) ?? props.listing.listing_images[0];
});

const moveToListingInfo = async () => {
    loading.value = true;
    try {
        await router.push({
            name: 'listing info',
            params: { listingId: selectedListing.value.id },
        });
    } catch(error) {
        error.value = error.response?.data?.message || 'failed to move to listing info';
    } finally {
        loading.value = false;
    }
}

</script>
<style scoped>
.container {
    display: flex;
    flex-direction: column;
    width: 100%;
    height: 500px;
    background-color: #FFFFFF;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.img-wrapper {
    width: 100%;
    height: 250px;
    overflow: hidden;
    background-color: #f3f4f6;
}

.listing-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.listing-details {
    display: flex;
    flex-direction: column;
    padding-top: 16px;

    box-sizing: border-box;
}

.price-listing {
    font-size: 18px;
    margin: 0 0 8px 0;
    margin-left: 20px;
}

.address-line-1-text {
    font-size: 18px;
    color: #1c1e21;
    margin-left: 20px;
}

.postcode-town-wrapper {
    display: flex;
    align-items: center;
    margin-top: 20px;
    gap: 5px;
    margin-left: 20px;
}

.location-img {
    height: 16px;
}

.town-text {
    font-size: 16px;
    color: #65676b;
}

.house-information {
    display: flex;
    align-items: center;
    margin-top: 30px;
    gap: 20px;
    margin-left: 20px;
}

.topic-wrapper {
    display: flex;
    align-items: center;
}

.num-and-info {
    display: flex;
    flex-direction: column;
    padding-left: 8px;
}

.rooms-icon,
.pin-icon {
    height: 28px;
}

.tiny-text-below-info {
    font-size: 12px;
    color: #65676b;
}

.horizontal-line {
    width: 100%;
    border: none;
    margin-top: 15px;
    margin-left: 0;
    border-top: 1px solid #e4e6eb;

}

.description-wrapper {
    margin-top: 4px;
    color: #65676b;
    font-size: 13px;
}

.description-text {
    margin-top: 3px;
    display: -webkit-box;
    margin-left: 20px;
    margin-right: 20px;
    overflow-wrap: break-word;
}

.bottom-of-listing {
    display: flex;
    margin-left: 20px;
    align-items: center;
    justify-content: space-between;
    flex-direction: row;
    width: 90%;

}
.listing-stats {
    display: flex;

}
.logo-img {
    height: 70px;
    border-radius: 80px;
    width: 60px;
    margin-right: 5px;
}
.niproperties-text {
    font-size: 13px;
    font-weight: bold;
    margin-bottom: 3px;
}
.sitename-time-uploaded {
    display: flex;
    align-items: center;
    flex-direction: column;
}
.time-since-upload {
    color: #65676b;
    font-size: 13px;
}
.view-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 52px;
    width: 70px;
    border-radius: 12px;
    background-color: #2dcc95;
    cursor: pointer;
    border: 1px solid #FFFFFF;
    color: #FFFFFF;
    font-size: 15px;
}
.view-btn:hover {
    background-color: #2d6e53;
}
</style>
