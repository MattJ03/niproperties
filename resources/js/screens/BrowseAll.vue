<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="header-container">
            <div class="header-text-wrapper">
               <h1>Browse Properties</h1>
                <span class="total-listings-text">Total listings across Northern Ireland: {{ listingStore.listingsCount }}</span>
            </div>
            <select class="sort-dropdown">
            <option> Sort: Most recent</option>
            </select>
        </div>
        <div class="listing-and-filter-container">
            <div class="filter-container">
               <h2 class="filters-header">Filters</h2>
                <div class="buy-rent-section">
                    <p>rent or buy</p>
                    <div class="rent-buy-btn">
                        <button class="rent-btn" @click="filters.rentOrBuy = 'rent'"
                                 :class="{ active: filters.rentOrBuy === 'rent'}">Rent</button>
                        <button class="buy-btn" @click="filters.rentOrBuy = 'buy'"
                        :class="{ active: filters.rentOrBuy === 'buy'}">Buy</button>
                    </div>
                </div>
                <div class="price-section">

                </div>
            </div>
        <div class="listings-rows">
            <ListingGrid
                v-for="listing in listingStore.allListings"
                :listing="listing"
                key="listing.id"
                />
        </div>
        </div>
    </div>
</template>
<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import Navbar from "../components/Navbar.vue";
import { useListingStore } from "../stores/ListingStore.js";
import ListingGrid from "../components/ListingGrid.vue";
import {storeToRefs} from "pinia";

const loading = ref(false);
const error = ref('');
const listingStore = useListingStore();

const filters = reactive({
    rentOrBuy: '',
});



onMounted(() => {
    console.log('onMounted running')
    listingStore.getAllListings();
    console.log(listingStore.allListings.length);
});



</script>
<style scoped>
.container {
    display: flex;
    flex-direction: column;
    width: 100%;


}
.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-right: 50px;
    height: 11%;
    width: 100%;
    margin-top: 150px;
    margin-bottom: 40px;
    background-color: #FFFFFF;
}
.header-text-wrapper {
    display: flex;
    margin-left: 50px;
    padding-bottom: 20px;
    flex-direction: column;

}
.total-listings-text {
    font-size: 16px;
    color: #A9A9A9;
}
.sort-dropdown {
    font-size: 16px;
    cursor: pointer;
    color: #000000;
    background-color: #FDFBD4;
    padding: 10px 10px;
    border-radius: 10px;
    margin-right: 65px;
}

.listings-rows {
    display: grid;
    flex-direction: row;
    margin-top: 40px;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    align-items: start;
    gap: 20px;
    width: 100%;
    padding: 0 50px;
}
.filter-container {
    display: flex;

    height: 700px;
    flex-direction: column;
    border: 1px solid #FFFFFF;
    width: 30%;
    margin-left: 40px;
    border-radius: 12px;
    background-color: #FFFFFF;
}
.listing-and-filter-container {
    display: flex;
    flex-direction: row;
}
.filters-header {
    margin-left: 40%;
}
.buy-rent-section {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;

}
.rent-buy-btn {
    display: flex;
    gap: 5px;
    cursor: pointer;

}
.rent-btn {
    padding: 16px 16px;
    border-radius: 14px;
    background-color: #FFFFFF;
    border: 1px solid #000000;
    cursor: pointer;

}
.rent-btn.active {
    background-color: #2d6e53;
    color: #FFFFFF;
}
.buy-btn {
    padding: 16px 16px;
    border-radius: 14px;
    background-color: #FFFFFF;
    border: 1px solid #000000;
    cursor: pointer;

}
.buy-btn.active {
    background-color: #2d6e53;
    color: #FFFFFF;
}
</style>
