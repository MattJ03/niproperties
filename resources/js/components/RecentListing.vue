<template>
    <div class="container">
        <div class="img-wrapper">
            <img  v-if="primaryImage" :src="`/api/listings/listing-images/${primaryImage.id}`" alt="listing image" class="listing-img"/>
            <div v-else class="no-image-placeholder">No Image Found</div>
        </div>
        <div class="listing-details-wrapper">
        <div class="listing-details">
            <span> {{ formatPrice(props.listing.price) }} </span>
            <span> {{ props.listing.address_line_1 }}</span>
            <span v-if="props.listing.address_line_2"> {{ props.listing.address_line_2 }}</span>
            <div class="small-info-wrapper">
            <span class="town-text"> {{ props.listing.town }}</span>
                <span class="town-text"> {{ props.listing.postcode}}</span>
            </div>
        </div>
        </div>

    </div>

</template>
<script setup>
import { ref, reactive, computed, onMounted } from 'vue';


const props = defineProps({
    listing: {
        type: Object,
        required: true,
    },
});

const noImage = ref('');

const primaryImage = computed(() => {
    if(props.listing.listing_images === null) {
        noImage.value = 'No Image Found'
        return null;
    }

    return props.listing.listing_images.find(img => img.is_primary) ?? props.listing.listing_images[0];
});

function formatPrice(price) {
   return Intl.NumberFormat(
        'en-GB',
        { style: "currency",
                 currency: "GBP"},

    ).format(price);
}
</script>
<style scoped>
.container {
    display: flex;
    flex-direction: column;
    height: 48dvh;

    border-radius: 12px;
    border: 1px solid #000000;
    flex-direction: column;

}
.img-wrapper {
    display: flex;
    justify-content: center;
    height: 70%;
    width: 100%;
}
.listing-img {
    width: 100%;
    border-radius: 12px 12px 0px 0px;
}
.listing-details-wrapper {
    display: flex;
    justify-content: left;
    width: 100%;
    height: 100%;
    border-radius: 12px;
    background-color: #1a202c;
}
.listing-details {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    width: 100%;

}
.listing-details span {
    font-size: 15px;

}
.town-text {
    color: #A9A9A9;
    font-size: 15px;
}
.no-image-placeholder {
    height: 100px;
    width: 100px;


}
</style>
