<template>
 <div class="listing-card">
     <div class="img-wrapper">
         <img :src="`/api/listings/listing-images/${primaryImage.id}`" class="listing-image" alt="listing image" />
     </div>
     <span v-if="props.listing.price" class="price-text"> £{{ props.listing.price }} </span>
     <div v-if="props.listing.rent_per_month" class="rent-section">
     <span class="rent-text"> {{ props.listing.rent_per_month }}</span>
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
                     <span> beds</span>
                 </div>
                 <div class="field-and-img">
                     <img :src="bathroom" class="bathroom-img" alt="bathroom"/>
                     <span>Bathrooms</span>
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
         </div>
     </div>
 </div>

</template>
<script setup>
import { ref, reactive, computed } from 'vue';
import location from '../assets/location.png';
import rooms from '../assets/rooms2.png';
import bed from '../assets/bed.png';
import bathroom from '../assets/bathroom.png';
import dayjs from "dayjs";
import RelativeTime from 'dayjs/plugin/relativeTime.js';


const noImage = ref('')
const props = defineProps({
    listing: {
        type: Object,
        require: true,
    },
});

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
</script>
<style scoped>
.listing-card {
    display: flex;
    flex-direction: column;
    background-color: #f3f4f6;
    width: 80%;
    height: 550px;
    border-radius: 12px;

    cursor: pointer;

}
.img-wrapper {
    overflow: hidden;
    height: 40%;
    width: 100%;
}
.listing-image {
    height: 100%;
    width: 100%;
    object-fit: cover;
    border-radius: 12px;
}
.address-section {
    display: flex;
    flex-direction: column;
    margin-left: 20px;

    margin-top: 10px;
    width: 100%;
}
.price-text {
    font-weight: bold;
    margin-top: 15px;
    margin-left: 20px;
    font-size: 22px;
}
.rent-text {
    font-weight: bold;
    margin-top: 15px;
    margin-left: 20px;
    font-size: 22px;
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
    margin-top: 7px;
}
.town-postcode-wrapper span {
    font-size: 14px;
}
.location-img {
    height: 16px;
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
    font-size: 15px;
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
    justify-content: right;
}
.created-at-text {
    color: #88807b;
    margin-right: 20px;
}
</style>
