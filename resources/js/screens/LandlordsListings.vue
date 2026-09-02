<template>
    <Navbar></Navbar>
  <div class="container">
      <div class="landlord-header-wrapper">
          <img :src="profilePicture" alt="profile picture" class="profile-picture" />
          <h2 class="landlord-name"> {{  landlord.name }}</h2>
          <div class="filters-container">
              <div class="field">
                  <label class="field-text">County</label>
              <select v-model="filters.county" class="county-dropdown" >
                  <option class="county-option" v-for="county in counties" >
                      {{ county }}
                  </option>
              </select>
              </div>
              <div class="field">
              <div class="rent-buy-wrapper">
                  <button class="rent-btn" @click="filters.rent_or_buy = 'rent'"
                  :class="{ active: filters.rent_or_buy === 'rent'}"
                  >Rent</button>
                  <button class="buy-btn" @click="filters.rent_or_buy = 'buy'"
                   :class="{ active: filters.rent_or_buy === 'buy'}"
                  >Buy</button>
              </div>
              </div>
              <div class="min-rooms-wrapper">
              <div class="field">
                  <label class="field-text">Min rooms</label>
                  <select class="min-rooms-dropdown" v-model="filters.min_num_rooms">
                      <option v-for="num in rooms">
                      {{ num }}
                      </option>
                  </select>
              </div>
          </div>
              <div class="search-wrapper">
                  <div class="search-bar">
                  <img :src="search2" class="search-img" alt="search image"/>
                  <input type="text"  v-model="search" class="search-input" placeholder="postcode, town, county..."/>
                  </div>
                  </div>
              <div class="filters-wrapper">
              <button class="apply-filters-btn">Apply filters</button>
                  <span class="remove-filters-text" @click="removeFilters()">
                      <img :src="reset" class="reset-img" alt="reset"/>
                  Reset Filters
                  </span>
              </div>
              </div>
      </div>
      <div class="listings-list">
          <LandlordListing
              v-for="listing in listingStore.landlordListings"
              :listing="listing"
              :id="listing.id"
              />
      </div>
      <div class="pagination-container">
          <div class="pagination-wrapper">
              <button class="previous-btn">
                  <span>></span>
                  <span>Previous</span>
              </button>
              <div class="num-wrapper">
                  <button v-for="num in numRoomsRange" class="page-num-button">
                      {{ num }}
                  </button>
                  <div class="more-btn">
                      ...
                  </div>
                  <div class="final-page-num">

                  </div>
              </div>
          </div>
      </div>
  </div>

</template>
<script setup>
import Navbar from "../components/Navbar.vue";
import { useListingStore } from "../stores/ListingStore.js";
import {computed, onMounted, reactive, ref} from "vue";
import profilePicture from '../assets/agent.png';
import search2 from '../assets/search.png';
import {useRoute} from "vue-router";
import reset from '../assets/reset.png';
import LandlordListing from "../components/LandlordListing.vue";
import {storeToRefs} from "pinia";

const listingStore = useListingStore();
const counties = ['Fermanagh', 'Antrim', 'Tyrone', 'Londonderry', 'Armagh', 'Down'];

const route = useRoute();
const numRoomsRange = ref([1, 2, 3, 4, 5]);
const finalPageNum = ref(0);
const finalPageNumRounded = ref(finalPageNum.value);
const { landlordListings } = storeToRefs(listingStore)

const getFinalPageNum = computed(() => {

});

const filters = reactive({
    county: '',
    rent_or_buy: '',
    min_price: '',
    max_price: '',
    min_num_rooms: '',
});
const search = ref('');
const rooms = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

const props = defineProps({
    landlordId: {
        type: String,
        required: true,
    },
});

const landlord = computed(() => listingStore.landlord);

onMounted(async () => {

    if (!landlord.value || landlord.value.id !== props.landlordId) {
        await listingStore.fetchLandlordById(props.landlordId);
    }
    console.log('listings:', listingStore.landlordListings);
});

const removeFilters = () => {
    filters.rent_or_buy = '';
        filters.county = '';
        filters.max_price = '';
        filters.min_price = '';
        filters.min_num_rooms = '';
        search.value = '';
};
</script>
<style scoped>
.container {
    display: flex;
    flex-direction: column;

    align-items: center;
    width: 100%;
    min-height: 100dvh;

}
.landlord-header-wrapper {
    display: flex;
    align-items: center;
   margin: 0 auto;
    margin-top: 150px;
    height: 100px;
    width: fit-content;
    gap: 40px;


    padding-left: 30px;
    padding-right: 30px;

    background-color: #FFFFFF;
    border-radius: 12px;
}
.profile-picture {
    height: 70%;
    cursor: pointer;
    border-radius: 60px;
    padding: 10px 10px;
}
.profile-picture:hover {
    background-color: #F2EFE6;
}
.landlord-name {

}
.filters-container {
    display: flex;
    align-items: center;
    width: 100%;
    gap: 40px;
}
.county-dropdown {
    font-size: 16px;
    height: 50px;
    border-radius: 14px;
    padding: 10px 10px;
    background-color: #f3f4f6;
    cursor: pointer;
    border: 1px solid #FFFFFF;
}
.county-dropdown:hover {
    border: 1px solid #FF0000;
}
.field {
    display: flex;
    align-items: center;
    flex-direction: row;
    gap: 10px;
}
.field-text {
    font-size: 16px;
}
.rent-buy-wrapper {
    display: flex;
    flex-direction: row;

}
.rent-buy-btn {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    cursor: pointer;

}
.rent-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;

    height: 48px;
    padding: 0 34px;

    border-radius: 12px;
    background-color: #FFFFFF;
    border: 1px solid #F2EFE6;

    cursor: pointer;
    font-size: 16px;

}
.rent-btn:hover {
    border: 1px solid #FF0000;
}
.rent-btn.active {
    background-color: #2d6e53;
    color: #FFFFFF;
}
.buy-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;

    height: 48px;
    padding: 0 34px;

    border-radius: 12px;
    background-color: #FFFFFF;
    border: 1px solid #F2EFE6;

    cursor: pointer;
    font-size: 16px;

}
.buy-btn:hover {
    border: 1px solid #FF0000;
}
.buy-btn.active {
    background-color: #2d6e53;
    color: #FFFFFF;
}
.min-rooms-wrapper {
    display: flex;

}
.min-rooms-dropdown {
    font-size: 16px;
    height: 50px;
    border-radius: 14px;
    padding: 10px 10px;
    background-color: #f3f4f6;
    cursor: pointer;
    border: 1px solid #FFFFFF;

}
.min-rooms-dropdown:hover {
    border: 1px solid #FF0000;
}
.search-wrapper {
    display: flex;


    position: relative;

}
.search-bar {
    width: 100%;
}
.search-input {
    border-radius: 14px;
    height: 50px;
    width: 300px;
    background-color: #f3f4f6;
    padding-left: 30px;
    font-size: 16px;
    border: none;
}
.search-input:hover {
    border: 1px solid #FF0000;
}
.search-img {
    position: absolute;
    left: 10px;
    top: 50%;
    height: 18px;

    transform: translateY(-50%);
}
.apply-filters-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 50px;
    width: 120px;
    font-size: 16px;


    border-radius: 14px;
    color: #FFFFFF;
    background-color: #2dcc95;
    cursor: pointer;
    border: 1px solid #FFFFFF;
}
.apply-filters-btn:hover {
    background-color: #2d6e53;
}
.filters-wrapper {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    gap: 20px;
}
.remove-filters-text {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    color: #6b7280;
    cursor: pointer;
    gap: 3px;
}
.remove-filters-text:hover {
    color: #2d6e53;
}
.reset-img {
    height: 20px;
    width: 20px;
}
.listings-list {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 50%;
    margin-top: 30px;
    gap: 40px;
    flex-direction: column;

}
.pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-left: 30px;
        width: 100%;
        height: 8dvh;
    }
.pagination-wrapper {
    display: flex;
    align-items: center;
    height: 90%;
    margin-top: 40px;
    border: 1px solid #f7fafc;
    width: 50%;
    background-color: #FFFFFF;
    border-radius: 15px;
}
.previous-btn {
    display: flex;
    gap: 10px;
    align-items: center;
    height: 75%;
    width: 13%;
    margin-left: 15px;
    background-color: #FFFFFF;
    color: #6B46C1;
    font-size: 16px;
    border-radius: 15px;
    border: 1px solid #D6BCFA;
    padding-left: 20px;
    margin-right: 40px;
    cursor: pointer;
}
.previous-btn:hover {
    background-color: #CBC3E3;
}
.previous-btn:disabled {
    background-color: #E0E0E0;
    cursor : not-allowed;
}
.num-wrapper {
    display: flex;
    align-items: center;
    gap: 15px;
    height: 100%;
    width: 100%;
}
.page-num-button {
    display: flex;

    justify-content: center;
    align-items: center;
    width: 9%;
    height: 75%;
    font-size: 16px;
    border: 1px solid #6B46C1;
    border-radius: 15px;
    background-color: #FFFFFF;
    color: #6B46C1;
    cursor: pointer;

}
.page-num-button:hover {
    background-color: #CBC3E3;
}
.page-num-button.active {
    background-color: #6B46C1;
    color: #FFFFFF;
}
.more-btn {
    margin-left: 28px;
    color: #6B46C1;
}
.final-page-num {
    display: flex;

    justify-content: center;
    align-items: center;
    width: 9%;
    height: 75%;
    font-size: 16px;
    border: 1px solid #6B46C1;
    border-radius: 15px;
    background-color: #FFFFFF;
    color: #6B46C1;
    cursor: pointer;
    margin-left: 5px;
}

.next-btn {
    display: flex;
    gap: 10px;
    align-items: center;
    height: 75%;
    width: 13%;
    margin-left: 15px;
    background-color: #FFFFFF;
    color: #6B46C1;
    font-size: 16px;
    border-radius: 15px;
    border: 1px solid #D6BCFA;
    padding-left: 20px;
    margin-right: 40px;
    cursor: pointer;
}
.next-btn:hover {
    background-color: #CBC3E3;
}
.next-btn:disabled {
    background-color: #E0E0E0;
    cursor: not-allowed;
}
</style>
