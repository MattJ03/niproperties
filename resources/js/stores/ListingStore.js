import { ref, reactive, computed } from 'vue';
import {defineStore} from "pinia";
import api from '../axios.js';

export const useListingStore = defineStore('listings', () => {
   const loading = ref(false);
   const error = ref('');
   const listings = ref([]);
   const listing = ref('');

   const storeListing = async (payload) => {
       loading.value = true;
       try {
           const res = await api.post(`/storeListing`, payload);
           listing.value = res.data.listing;
       } catch (err) {
           error.value = error.response?.data?.message ?? 'failed to store listing';
       } finally {
           loading.value = false;
       }
   }

   return {
       loading,
       error,
       listings,
       listing,
       storeListing,
   };
});
