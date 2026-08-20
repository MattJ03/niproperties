import { ref, reactive, computed } from 'vue';
import { defineStore } from "pinia";
import api from '../axios.js';

export const useUserDirectoryStore = defineStore('user_directory', () => {
   const loading = ref(false);
   const error = ref('');
   const landlords = ref([]);
   const landlordCount = ref('');
   const totalListingsLandlord = ref('');

   async function getLandlords() {
       loading.value = true;
       try {
           const res = await api.get(`getLandlords`);
           landlords.value = res.data.landlords;
           landlordCount.value = res.data.landlord_count;
           totalListingsLandlord.value = res.data.listings_count;
       } catch(err) {
           error.value = error.response?.data?.message || 'failed to get the landlord info';
       } finally {
           loading.value = false;
       }
   }

   return {
       loading,
       error,
       landlords,
       landlordCount,
       totalListingsLandlord,
       getLandlords,
   }

});
