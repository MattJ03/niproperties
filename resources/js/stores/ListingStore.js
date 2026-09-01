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
   const landlordsRecentListings = ref([]);
    const landlordId = ref('');
    const landlord = ref('');
   const landlordListings = ref([]);

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

   const getAllListings = async (filters = {}) => {
       loading.value = true;
       try {
           console.log('tried');
           const res = await api.get('/listingsIndex', {
               params: filters,
           });
           allListings.value = res.data.listings;
           console.log(allListings.value.length + 'checking in store');
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

   const getListingsOrderedByViews = async (filters = {}) => {
       loading.value = true;
       try {
           const res = await api.get(`listingsIndexByViews`, {
               params: filters,
           });
           allListings.value = res.data.listings;
       } catch(err) {
           error.value = error.response?.data?.message || 'failed to get listings by views';
       } finally {
           loading.value = false;
       }
   }

   const getListingsOrderedByPrice = async (filters = {}) => {
       loading.value = true;
       try {
           const res = await api.get(`listingsIndexByPrice`, {
               params: filters,
           });
           allListings.value = res.data.listings;
       } catch(err) {
           error.value = error.response?.data?.data?.message || 'failed to get listings by price';
       }
       finally {
           loading.value = false;
       }
   }

   const getListingsOrderedByPriceLowestToHighest = async (filters = {}) => {
       loading.value = true;
       try {
           const res = await api.get(`listingsIndexLowestToHighest`, {
               params: filters,
           });
           allListings.value = res.data.listings;
       } catch(err) {
           error.value = error.response?.data?.message || 'failed to get listings ordered by low to high price';
       }
   }

   const getRentListings = async (filters = {}) => {
       loading.value = true;
       try {
           const res = await api.get(`listingsRent`, {
               params: filters,
           });
           allListings.value = res.data.listings;
       } catch(err) {
           error.value = error.response?.data?.message || 'failed to get rent listing';
       } finally {
           loading.value = false;
       }
    }

    const getLandlordsRecentListings = async (landlordId) => {
       loading.value = true;
       try {
           console.log('recent method running');
           const res = await api.get(`getRecentListingsForLandlord/${landlordId}`);
           landlordsRecentListings.value = res.data.listings;
           console.log('recent value changed' + landlordsRecentListings.value.length);
       } catch(err) {
           error.value = error.response?.data?.message || 'failed to getRecentListings';
       } finally {
           console.log('method over');
           loading.value = false;
       }
    }

    const getLandlordsListings = async (landlordId) => {
       loading.value = true;
       try {
           const res = await api.get(`getLandlordsListings/${landlordId}`);
           landlordListings.value = res.data.listings;
       } catch(err) {
           error.value = error.response?.data?.message || 'failed to get landlords listings';
       } finally {
           loading.value = false;
       }
    }

    const fetchLandlordById = async (id) => {
       loading.value = true;
       try {
           const res = await api.get(`getLandlord/${id}`);
           landlord.value = res.data.landlord;
       } catch(err) {
           error.value = error.response?.data?.message || 'failed to get landlord by id';
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
       landlordsRecentListings,
       landlordId,
       landlord,
       landlordListings,
       storeListing,
       getAllListings,
       get3RecentListings,
       getListingsOrderedByViews,
       getListingsOrderedByPrice,
       getListingsOrderedByPriceLowestToHighest,
       getRentListings,
       getLandlordsRecentListings,
       getLandlordsListings,
       fetchLandlordById,
   };
});
