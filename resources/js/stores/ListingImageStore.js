import { ref, reactive, computed } from 'vue';
import { defineStore } from "pinia";
import api from '../axios.js';


export const useListingImageStore = defineStore('listing_images', () => {
    const loading = ref(false);
    const error = ref('');


    const storeListingImage = async (listingId, images, primaryIndex) => {
        loading.value = true;
        try {
            for(const [index, img] of images.entries()) {
                const formData = new FormData();
                formData.append('file', img.file);
                formData.append('is_primary', index === primaryIndex ? 1 : 0);


                await api.post(`/listings/${listingId}/images`, formData);
            }
        } catch (err) {
            error.value = error.response?.data?.message ?? 'Failed to upload images'
        } finally {
            loading.value = false;
        }
    }

    return {
        loading,
        error,
        storeListingImage,
    };
});
