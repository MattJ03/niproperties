<template>
    <div class="container">
        <div class="img-wrapper">
            <img  v-if="primaryImage" :src="`/listings/images/${primaryImage.id}`" alt="listing image" />
            <div v-else class="no-image-placeholder">No Image Found</div>
        </div>
        <div class="listing-details">
            <span>£ {{ props.listing.price }} </span>
            <span> {{ props.listing.address_line_1 }}</span>
            <span v-if="props.listing.address_line_2"> {{ props.listing.address_line_2 }}</span>
            <div class="small-info-wrapper">
            <span class="town-text"> {{ props.listing.town }}</span>
                <span class="town-text"> {{ props.listing.postcode}}</span>
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
})
</script>
<style scoped>
.container {
    display: flex;
    flex-direction: column;
    height: 50dvh;

    border-radius: 12px;
    border: 1px solid #000000;
    flex-direction: column;

}
.img-wrapper {
    display: flex;
    height: 100px;
    width: 100px;
}
.listing-details {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;


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
