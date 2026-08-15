<template>
    <div class="container">
        <div class="img-half-wrapper">
            <img v-if="getPrimaryImage" :src="`api/listings/listing-images/${getPrimaryImage.id}`" class="listing-image" alt="listing image" />
        </div>
        <div class="info-half-wrapper">
            <div class="time-ago-wrapper">
                <p class="time-since-upload"> {{ dayjs(props.listing.created_at).fromNow() }}</p>
            </div>
        </div>
    </div>

</template>
<script setup>
import { ref, reactive, computed } from 'vue';
import dayjs from "dayjs";
import RelativeTime from 'dayjs/plugin/relativeTime.js';

const props = defineProps({
    listing: {
        type: Object,
        required: true,
    },
});
const noImage = ref('');
dayjs.extend(RelativeTime);

const getPrimaryImage = computed(() => {
    if(props.listing.listing_images === null || props.listing.listing_images === undefined) {
        noImage.value = 'no images';
        return null;
    }
    return props.listing.listing_images.find(img => img.isPrimary) ?? props.listing.listing_images[0];

})
</script>
<style scoped>
.container {
    display: flex;
    width: 40%;
    margin-top: 154px;
    height: 300px;
    flex-direction: row;
    background-color: #FFFFFF;
    border-radius: 24px;
    margin-left: 50px;

}
.img-half-wrapper {
    height: 100%;
    width: 50%;
    overflow: hidden;
    border-radius: 14px;
}
.listing-image {
    height: 80%;
    width: 100%;
    object-fit: cover;
}
.info-half-wrapper {
    display: flex;
}
.time-ago-wrapper {

}
.time-since-upload {
    color: #65676b;
}
</style>
