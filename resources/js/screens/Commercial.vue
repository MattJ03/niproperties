<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="filter-and-listings-container">
            <div class="filter-container">
                <div class="top-of-container">
                    <h2 class="filter-header">Filters</h2>
                    <div class="reset-wrapper" @click="resetFilters()">
                        <img :src="reset" class="reset-img" alt="reset" />
                        <span class="reset-text">Reset Filters</span>
                    </div>
                </div>
                <p class="filter-topic">Rent or buy</p>
                <div class="row">
                    <div class="rent-buy-section">
                    <button @click="filters.rent_or_buy = 'rent'" class="rent-btn"
                    :class="{ active: filters.rent_or_buy === 'rent'}">
                        <img :src="keys" class="keys-img" alt="keys"/>
                    <span>Rent</span>
                    </button>
                        <button class="buy-btn" @click="filters.rent_or_buy = 'buy'"
                        :class="{ active: filters.rent_or_buy === 'buy'}">
                            <img :src="housesquare" class="house-img" alt="house"/>
                            <span>Buy</span>
                        </button>
                </div>
                </div>
                <p class="filter-topic">Price range</p>
                <div class="row">
                   <input v-model="filters.min_price" type="number" placeholder="min-price" class="min-price-range-box"/>
                    <input v-model="filters.max_price" type="number" placeholder="max-price" class="max-price-range-box"/>
                    </div>
                <p class="filter-topic">County</p>
                <div class="row">
                    <select v-model="filters.county" class="county-dropdown">
                        <option class="county-value-text" v-for="county in counties"> {{ county }} </option>
                    </select>
                </div>
                <p class="filter-topic">Number of rooms</p>
                    <div class="numbers-wrapper">
                        <div class="num-square" @click="filters.min_num_rooms = ''; filters.max_num_rooms = ''"
                        :class="{ active: filters.min_num_rooms === '' }">Any</div>

                    <div class="num-square" @click="filters.min_num_rooms = '1'; filters.max_num_rooms = '4'"
                    :class="{ active: filters.min_num_rooms === '1' }">
                        1-4
                    </div>
                    <div class="num-square" @click="filters.min_num_rooms = '5'; filters.max_num_rooms = '7'"
                    :class="{ active: filters.min_num_rooms === '5'}">
                        5-7
                    </div>
                    <div class="num-square" @click="filters.min_num_rooms = '8'; filters.max_num_rooms = '10'"
                    :class="{ active: filters.min_num_rooms === '8'}">
                        8-10
                    </div>
                    <div class="num-square" @click="filters.min_num_rooms = '11'; filters.max_num_rooms = ''"
                    :class="{ active: filters.min_num_rooms === '11'}">
                        11+
                    </div>
                    </div>
                <div class="keywords-section">
                    <p class="filter-topic">Search</p>
                    <div class="search-input-wrapper">
                        <img :src="search2" class="search-img" alt="search" />
                        <input type="text" v-model="search" class="search-input" placeholder="search commercial properties"/>
                    </div>
                </div>
                <div class="apply-filters-section">
                <button class="apply-filters-button" @click="applyFilters()">
                    <img :src="filtersImg" class="filters-img" alt="scaffold"/>
                    <span class="apply-filters-text">Apply filters</span>
                </button>
                </div>
            </div>
            <div class="listings-rows">
                <ListingGrid
                    v-for="listing in listingStore.allListings"
                    :listing="listing"
                    key="listing.id"
                    />
                <h2 v-if="listingStore.noListings" class="no-listings-text">No listings found</h2>
            </div>
        </div>
        <div class="pagination-container">
            <div class="pagination-wrapper">
                <button class="previous-btn" @click="getPreviousPageListings()" :disabled="pageNum === 1">
                    <span><</span>
                    <span>Previous</span>
                </button>
                <div class="num-wrapper">
                    <button v-for="num in numRoomsRange" class="page-num-button" @click="getPaginatedListings(num)"
                            :class="{ active: num === pageNum}">
                        {{ num }}
                    </button>
                    <div class="more-btn">
                        ...
                    </div>
                    <button class="final-page-num" @click="getLastPageListings(finalPageNumRounded)">
                        {{ getFinalPageNum() }}
                    </button>
                </div>

                <button class="next-btn" @click="getNextPageListings()" :disabled="pageNum >= finalPageNumRounded">
                    <span>Next</span>
                    <span>> </span>
                </button>
            </div>
        </div>
        <span class="info-number-listings-page">Showing 1 - {{ listingStore.allListings.length }} of {{ listingsCount }} properties</span>
    </div>


</template>
<script setup>
import {ref, reactive, computed, onMounted, watch} from 'vue';
import Navbar from "../components/Navbar.vue";
import reset from '../assets/reset.png';
import search2 from '../assets/search.png';
import filtersImg from '../assets/scaffolding2.png';
import ListingGrid from "../components/ListingGrid.vue";
import keys from '../assets/keys2.png';
import housesquare from '../assets/housesquare.png';
import { useListingStore } from "../stores/ListingStore.js";
import {storeToRefs} from "pinia";


const filters = reactive({
    rent_or_buy: '',
    min_price: '',
    max_price: '',
    min_num_rooms: '',
    max_num_rooms: '',
    county: '',
});

const search = ref('');
const listingStore = useListingStore();
const counties = ref(['Fermanagh', 'Antrim', 'Tyrone', 'Londonderry', 'Armagh', 'Down']);
const numOfRooms = ref([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
const pageNum = ref(1);
const finalPageNum = ref(0);
const finalPageNumRounded = ref(finalPageNum.value);
const numRoomsRange = ref([1, 2, 3, 4, 5]);
const { listingsCount } = storeToRefs(listingStore);
const loading = ref(false);
const error = ref('');
const getFinalPageNum = () => {
    finalPageNum.value = listingsCount.value / 16;
    return finalPageNumRounded.value = Math.ceil(finalPageNum.value);
}

console.log(listingStore.allListings.length);

const applyFilters = async () => {
    await listingStore.getCommercialListings({
        rent_or_buy: filters.rent_or_buy || null,
        min_price: filters.min_price || null,
        max_price : filters.max_price,
        min_num_rooms: filters.min_num_rooms || null,
        max_num_rooms: filters.max_num_rooms || null,
        county: filters.county || null,
        search: search.value || null,
    });
}

const resetFilters = async () => {
    filters.rent_or_buy = '';
    filters.min_price = '';
    filters.max_price = '';
    filters.min_num_rooms = '';
    filters.max_num_rooms = '';
    filters.county = '';
    await listingStore.getCommercialListings();
}

const getNextPageListings = async () => {
    loading.value = true;
    pageNum.value++;
    try {
        await listingStore.getCommercialListings({
            ...filters,
                page: pageNum.value,
        });
    } catch (error) {
        error.value = error.response?.data?.message || 'failed to get next paginated commercial listings';
    } finally {
        loading.value = false;
    }
}

const getPreviousPageListings = async () => {
    loading.value = true;
    pageNum.value--;
    try {
        await listingStore.getCommercialListings({
            ...filters,
            page: pageNum.value,
        });
    } catch(error) {
        error.value = error.response?.data?.message || 'failed to get previous paginated listings';
    } finally {
        loading.value = false;
    }
}


onMounted(async () => {
   await listingStore.getCommercialListings();
});
</script>
<style scoped>
.container {
    display: flex;
    flex-direction: column;
    width: 100%;
}
.filter-and-listings-container {
    display: flex;
    margin-top: 150px;
    flex-direction: row;
}
.filter-container {
    display: flex;
    flex-direction: column;
    width: 22%;
    padding-bottom: 20px;
    border-radius: 12px;
    border: 1px solid #FFFFFF;
    background-color: #FFFFFF;

    margin-left: 40px;

}
.listings-rows {
    display: flex;
    flex-direction: row;
    grid-template-columns: repeat(auto-fill, minmax(280px,1fr));
    gap: 20px;
    min-height: 0;
    min-width: 0;
    padding: 0 50px;
}
.top-of-container {
    display: flex;
    width: 100%;
    justify-content: space-between;
}
.filter-header {
    margin-left: 30px;
}
.reset-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 40px;
    gap: 2px;
    cursor: pointer;
}
.reset-img {
    height: 20px;
}
.reset-text {
    font-size: 18px;
    color: #2d6e53;
}
.row {
    display: flex;
    flex-direction: row;


    margin-left: 30px;
    gap: 15px;

}
.filter-topic {
    margin-top: 30px;
    margin-left: 30px;
    font-weight: bold;
    font-size: 18px;
}
.min-price-range-box {
    height: 55px;
    width: 45%;
    padding-left: 15px;
    border-radius: 12px;
    border: 1px solid #F2EFE6;
    font-size: 16px;
}
.min-price-range-box:hover {
    border: 1px solid #FF0000;
}
.max-price-range-box {
    height: 55px;
    width: 45%;
    padding-left: 15px;
    border-radius: 12px;
    border: 1px solid #F2EFE6;
    font-size: 16px;
}
.max-price-range-box:hover {
    border: 1px solid #FF0000;
}
.county-dropdown {
    height: 55px;
    width: 90%;
    border: 1px solid #F2EFE6;
    background-color: #FFFFFF;
    border-radius: 12px;
    padding-left: 15px;
}
.county-dropdown:hover {
    border: 1px solid #FF0000;
    cursor: pointer;
}
.county-value-text {
    background-color: #000000;
    color: #FFFFFF;
    font-size: 16px;
}

.numbers-wrapper {
    display: flex;
    margin-left: 30px;
    padding-right: 10px;
    width: 100%;
    flex-direction: row;
    gap: 10px;
}
.num-square {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 40px;
    width: 60px;
    border: 1px solid #F2EFE6;
    border-radius: 14px;
    cursor: pointer;
}
.num-square:hover {
    border: 1px solid #FF0000;
}
.num-square.active {
    background-color: #2d6e53;
    color: #FFFFFF;
}
.search-input-wrapper {
    position: relative;
    width: 100%;
    margin-left: 30px;
}
.search-img {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);

    width: 20px;
    height: 22px;
}
.search-input {
        width: 85%;
        height: 50px;
        border: 1px solid #F2EFE6;
        border-radius: 12px;
        padding: 0 16px 0 45px;
        font-size: 16px;
    }
    .search-input:hover {
        border: 1px solid #FF0000;
    }
    .apply-filters-section {
        display: flex;
        justify-content: center;
    }
.apply-filters-button {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 70%;
    height: 60px;
    gap: 5px;
    border-radius: 12px;
    margin-top: 20px;
    background-color: #2d6e53;
    color: #FFFFFF;
}
.apply-filters-button:hover {
    background-color: #1F4D3A;
}
.filters-img {
    height: 24px;
}
.apply-filters-text {
    font-size: 17px;
}
.rent-buy-section {
    display: flex;
    margin-left: 30px;
}
.keys-img {
    height: 18px;
    width: 50%;
    padding: 6px 6px;
    background-color: #FDFBD4;
    border-radius: 80%;
}
.rent-buy-btn {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    cursor: pointer;
}
.rent-buy-section {
    display: flex;
    gap: 10px;
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
.house-img {
    height: 18px;
    width: 50%;
    padding: 6px 6px;
    background-color: #FDFBD4;
    border-radius: 80%;
}
.no-listings-text {
    width: 100%;
    margin: auto;
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
.info-number-listings-page {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 40px;
}
</style>
