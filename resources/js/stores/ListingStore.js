import { ref, reactive, computed } from 'vue';
import {defineStore} from "pinia";
import api from '../axios.js';

export const useListingStore = defineStore('listings', () => {
   const loading = ref(false);
   const error = ref('');
   const allListings = ref([]);
   const listing = ref('');
   const listingId = ref(null);
   const recentListings = ref([]);
   const listingsCount = ref('');

   const storeListing = async (payload) => {
       loading.value = true;
       try {
           const res = await api.post(`/storeListing`, payload);
           listing.value = res.data.listing;
           listingId.value = res.data.listing.id;
       } catch (err) {
           error.value = error.response?.data?.message ?? 'failed to store listing';
       } finally {
           loading.value = false;
       }
   }

   const getAllListings = async () => {
       loading.value = true;
       try {
           console.log('tried');
           const res = await api.get('/listingsIndex');
           allListings.value = res.data.listings;
           console.log(allListings.value.length);
           listingsCount.value = res.data.listings_count;
       } catch(err) {
           error.value = error.response?.data?.message || 'failed to get all listings';
       } finally {
           loading.value = false;
       }
   }

   const get3RecentListings = async () => {
       loading.value = true;
       try {
           const res = await api.get('/listingsRecent3');
           recentListings.value = res.data.listings;
       } catch(err) {
           error.value = error.response?.data?.message || 'unable to get the 3 recent listings';
       } finally {
           loading.value = false;
       }
   }

   return {
       loading,
       error,
       allListings,
       listing,
       listingId,
       recentListings,
       listingsCount,
       storeListing,
       getAllListings,
       get3RecentListings,
   };
});
