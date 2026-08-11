<template>
    <div class="container">
        <div class="img-wrapper">
            <img v-if="primaryImage" :src="`/api/listings/listing-images/${primaryImage.id}`" class="listing-img" alt="listing image" />
        </div>
        <div class="listing-details">
            <strong><p class="price-listing">£{{ props.listing.price}}</p></strong>
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
    height: 500px;
    background-color: #FFFFFF;
    border-radius: 12px;
}
.img-wrapper {
    width: 100%;
    height: 250px;
    overflow: hidden;
}
.listing-img {
    width: 100%;
    height: 100%;
    border-radius: 12px;
    object-fit: cover;
}
.listing-details {
    display: flex;
    flex-direction: column;
    width: 100%;
    margin-left: 20px;
    margin-top: 20px;
}
.price-listing {
    font-size: 20px;
    margin-top: 0;
    margin-bottom: 17px;

}
.address-line-1-text {
    font-size: 18px;
}
.postcode-town-wrapper {
    display: flex;
    align-items: center;
    flex-direction: row;
    margin-top: 10px;
    gap: 5px;
}
.location-img {
    height: 18px;
}
.topic-wrapper {
    display: flex;
   margin-right: 30px;
}
.town-text {
    font-size: 16px;
    color: #65676b;
}
.house-information {
    display: flex;
    align-items: center;
    margin-top: 30px;
    width: 100%;

}
.num-and-info {
    display: flex;
    flex-direction: column;
   gap: 5px;
    padding-left: 10px;
}
.rooms-icon {
    height: 28px;
}
.rooms-info-text {

}
.pin-icon {
    height: 28px;
}
.county-info-text {

}
.tiny-text-below-info {
    font-size: 12px;
    color: #65676b;
}
.horizontal-line {
    width: 100%;
    color: #1c1e21;
    margin-left: -20px;
    margin-top: 15px;
}
.description-wrapper {

    margin-top: 5px;
    color: #65676b;
    font-size: 12px;

}
.bottom-of-listing {
    display: flex;
    flex-direction: column;
    width: 100%;

}
.listing-stats {
    display: flex;
}
.logo-img {
    height: 70px;
    border-radius: 80px;
    width: 21%;
    margin-right: 5px;
}
.niproperties-text {
    font-size: 13px;
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
</style>
