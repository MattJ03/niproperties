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
            <div class="bottom-of-listing">
                <hr class="horizontal-line" />
                <div class="listing-stats">
                    <img :src="logo" alt="niproperties logo" class="logo-img" />
                    <div class="sitename-time-uploaded">
                        <p class="niproperties-text">NI Properties</p>
                        <span class="time-since-upload"> {{ dayjs(props.listing.created_at).fromNow() }}</span>
                    </div>
                </div>
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

const noImage = ref('');
const props = defineProps({
    listing: {
        type: Object,
        required: true,
    },
});
const loading = ref(false);
const error = ref('');

const currentPage = ref(1);
const nextPage = ref(currentPage + 1);

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

</script>
<style scoped>
.container {
    display: flex;
    flex-direction: column;
    width: 100%;

    height: auto;
    background-color: #FFFFFF;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.img-wrapper {
    width: 100%;
    height: 180px;
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
    padding: 16px;
    box-sizing: border-box;
}

.price-listing {
    font-size: 18px;
    margin: 0 0 8px 0;
}

.address-line-1-text {
    font-size: 15px;
    color: #1c1e21;
}

.postcode-town-wrapper {
    display: flex;
    align-items: center;
    margin-top: 6px;
    gap: 5px;
}

.location-img {
    height: 16px;
}

.town-text {
    font-size: 14px;
    color: #65676b;
}

.house-information {
    display: flex;
    align-items: center;
    margin-top: 16px;
    gap: 20px;
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
    height: 24px;
}

.tiny-text-below-info {
    font-size: 12px;
    color: #65676b;
}

.horizontal-line {
    width: 100%;
    border: none;
    border-top: 1px solid #e4e6eb;
    margin: 12px 0;
}

.description-wrapper {
    margin-top: 4px;
    color: #65676b;
    font-size: 13px;
}

.description-text {
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.bottom-of-listing {
    display: flex;
    flex-direction: column;
    margin-top: auto;
}

.listing-stats {
    display: flex;
    align-items: center;
    gap: 10px;
}

.logo-img {
    height: 36px;
    width: 36px;
    border-radius: 50%;
    object-fit: cover;
}

.sitename-time-uploaded {
    display: flex;
    flex-direction: column;
}

.niproperties-text {
    font-size: 13px;
    margin: 0;
    font-weight: 600;
}

.time-since-upload {
    color: #65676b;
    font-size: 12px;
}
</style>
