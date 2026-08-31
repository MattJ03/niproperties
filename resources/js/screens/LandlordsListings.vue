<template>
    <Navbar></Navbar>
  <div class="container">
      <div class="landlord-header-wrapper">
          <img :src="profilePicture" alt="profile picture" class="profile-picture" />
          <h2 class="landlord-name"> {{ listingStore.landlord.name }}</h2>
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
                  <img :src="search" class="search-img" alt="search image"/>
                  <input type="text" class="search-input" placeholder="postcode, town, county..."/>
                  </div>
                  </div>
          </div>
      </div>
  </div>

</template>
<script setup>
import Navbar from "../components/Navbar.vue";
import { useListingStore } from "../stores/ListingStore.js";
import { onMounted, reactive, ref } from "vue";
import profilePicture from '../assets/agent.png';
import search from '../assets/search.png';

const listingStore = useListingStore();
const counties = ['Fermanagh', 'Antrim', 'Tyrone', 'Londonderry', 'Armagh', 'Down'];

const filters = reactive({
    county: '',
    rent_or_buy: '',
    min_price: '',
    max_price: '',
    min_num_rooms: '',
});
const rooms = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
onMounted(()=> {
    console.log('landlord id ' + listingStore.landlordId);
});
</script>
<style scoped>
.container {
    display: flex;
    width: 100%;
    min-height: 100dvh;
    background-color: #6B46C1;
}
.landlord-header-wrapper {
    display: flex;
    align-items: center;
    margin-top: 150px;
    height: 100px;
    width: 95%;
    margin-left: 20px;
    padding-left: 30px;
    padding-right: 20px;
    margin-right: 20px;
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
    margin-left: 15px;
}
.filters-container {
    display: flex;
    align-items: center;
    width: 100%;
    margin-left: 200px;
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
    margin-left: 120px;
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
    margin-left: 120px;
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
.search-wrapper {
    display: flex;
    margin-left: 120px;

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
    font-size: 15px;
}
.search-img {
    position: absolute;
    left: 10px;
    top: 50%;
    height: 18px;

    transform: translateY(-50%);
}
</style>
