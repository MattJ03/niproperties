<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="filter-and-listings-container">
                <div class="filter-container">
                    <div class="top-of-filters">
                        <h2 class="filters-header">Filters</h2>
                        <div class="reset-wrapper">
                            <img :src="reset" alt="reset image" class="reset-img" />
                            <span class="reset-filters" @click="resetFilters()">Reset Filters</span>
                        </div>
                    </div>
                    <div class="price-section">
                        <strong><p class="filter-topic">Price range</p></strong>
                        <div class="min-max-row">
                            <input type="number" class="min-max-input" v-model="filters.min_price" placeholder="min-price"/>
                            <input type="number" class="min-max-input" v-model="filters.max_price" placeholder="max-price"/>
                        </div>
                    </div>
                    <div class="county-section">
                        <strong><p class="filter-topic">County</p></strong>

                        <select v-model="filters.county" class="county-select">
                            <option class="dropdown-value-county" v-for="county in counties" > {{ county }}</option>
                        </select>
                    </div>
                    <div class="room-number-selection">
                        <strong><p class="filter-topic">Number of rooms</p></strong>
                        <div class="row-of-numbers">
                            <div class="square-num-rooms">
                                Any
                            </div>
                            <div class="square-num-rooms" @click="filters.min_num_of_rooms = '1'; filters.max_num_of_rooms = '4'"
                                 :class="{ active: filters.min_num_of_rooms === '1'}"
                            >
                                1-4
                            </div>
                            <div class="square-num-rooms" @click="filters.min_num_of_rooms = '5'; filters.max_num_of_rooms = '7'"
                                 :class="{ active: filters.min_num_of_rooms === 5}">
                                5-7
                            </div>
                            <div class="square-num-rooms" @click="filters.min_num_of_rooms = '8'; filters.max_num_of_rooms = '10'"
                                 :class="{ active: filters.min_num_of_rooms === '8'}">
                                8-10
                            </div>
                            <div class="square-num-rooms" @click="filters.min_num_of_rooms = '11'"
                                 :class="{ active: filters.min_num_of_rooms === '11'}">
                                11+
                            </div>
                        </div>
                    </div>
                    <div class="keywords-section">
                        <p class="filter-topic">Keywords</p>
                        <div class="keywords-input-wrapper">
                            <img :src="search2" class="search-icon" alt="search"/>
                            <input v-model="filters.search" type="text" class="keywords-input" />
                        </div>
                    </div>
                    <div class="button-wrapper">
                        <button class="apply-filters-btn" @click="applyFilters()">
                            <img :src="scaffolding" alt="scaffolding" class="img-in-btn" />
                            Apply filters</button>
                    </div>
                </div>
        <div class="rent-listings-container">
            <RentGrid
                v-for="listing in listingStore.allListings"
                :listing="listing"
                key="listing.id"
            />
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
import {ref, reactive, computed, onMounted, watch} from "vue";
import { useListingStore } from "../stores/ListingStore.js";
import Navbar from "../components/Navbar.vue";
import reset from "../assets/reset.png";
import keys from "../assets/keys2.png";
import housesquare from "../assets/housesquare.png";
import search2 from "../assets/search.png";
import scaffolding from "../assets/scaffolding2.png";
import RentGrid from "../components/RentGrid.vue";
import {storeToRefs} from "pinia";
import api from "../axios.js";

const filters = reactive({
    min_price: '',
    max_price: '',
    county: '',
    min_num_of_rooms: '',
    max_num_of_rooms: '',
    search: '',
});
const loading = ref(false);
const error = ref('');
const counties = ref(['Fermanagh', 'Antrim', 'Tyrone', 'Londonderry', 'Armagh', 'Down']);
const listingStore = useListingStore();
const numRoomsRange = ref([1, 2, 3, 4, 5]);
const pageNum = ref(1);
const finalPageNum = ref(0);
const finalPageNumRounded = ref(finalPageNum.value);
const sortOption = ref('recent');
const { listingsCount } = storeToRefs(listingStore);
const getFinalPageNum = () => {
    finalPageNum.value = listingsCount.value / 16;
    return finalPageNumRounded.value = Math.ceil(finalPageNum.value);
}

onMounted(async () => {
    await listingStore.getRentListings();
});

async function applyFilters() {
    await listingStore.getRentListings({
        min_price: filters.min_price || null,
        max_price: filters.max_price || null,
        county: filters.county || null,
        min_num_of_rooms: filters.min_num_of_rooms || null,
        max_num_of_rooms: filters.max_num_of_rooms || null,
        search: filters.search || null,
    });
}

async function resetFilters() {
    filters.county = '';
    filters.max_num_of_rooms = '';
    filters.min_num_of_rooms = '';
    filters.min_price = '';
    filters.max_price = '';
    filters.search = '';
    listingStore.getRentListings();
}
async function getPaginatedListings(page) {
    loading.value = true;
    try {
        pageNum.value = page;
        if(sortOption.value === 'recent') {
            const res = await api.get(`listingsRent?page=${pageNum.value}`, {
                params: filters,
            });
            listingStore.allListings = res.data.listings;
        }
        if(sortOption.value === 'views') {
            const res = await api.get(`listingsIndexByViews?page=${pageNum.value}`, {
                params: filters,
            });
            listingStore.allListings = res.data.listings;
        }
        if(sortOption.value === 'price-high-to-low') {
            const res = await api.get(`listingsIndexByPrice?page=${pageNum.value}`, {
                params: filters,
            });
            listingStore.allListings = res.data.listings;
        }
        if(sortOption.value === 'price-low-to-high') {
            const res = await api.get(`listingsIndexLowestToHighest?page=${pageNum.value}`, {
                params: filters,
            });
            listingStore.allListings = res.data.listings;
        }
    } catch(err) {
        error.value = error.response?.data?.message || 'failed to get paginated values next page';
    } finally {
        loading.value = false;
    }
}

async function getLastPageListings(finalPageNum) {
    loading.value = true;
    try {
        if(sortOption.value === 'recent') {
            const res = await api.get(`listingsRent?page=${finalPageNum.value}`, {
                params: filters,
            });
            listingStore.allListings = res.data.listings;
        }
        if(sortOption.value === 'views') {
            const res = await api.get(`listingsIndexByViews?page=${finalPageNum}`, {
                params: filters,
            });
            listingStore.allListings = res.data.listings;
        }
        if(sortOption.value === 'price-high-to-low') {
            const res = await api.get(`listingsIndexByPrice?page=${finalPageNum}`, {
                params: filters,
            });
            listingStore.allListings = res.data.listings;
        }
        if(sortOption.value === 'price-low-to-high') {
            const res = await api.get(`listingsIndexLowestToHighest?page=${finalPageNum}`, {
                params: filters,
            });
            listingStore.allListings = res.data.listings;
        }
    } catch(err) {
        error.value = error.response?.data?.message || 'failed to get paginated values next page';
    } finally {
        loading.value = false;
    }
}

watch(sortOption, (newValue, oldValue) => {
    console.log('Sort option changed to ' + newValue);
});

async function getNextPageListings() {
    loading.value = true;
    try {
        pageNum.value++;
        if(sortOption.value === 'recent' || undefined) {
            const res = await api.get(`listingsRent?page=${pageNum.value}`, {
                params: filters,
            });
            listingStore.allListings = res.data.listings;
        }
        if(sortOption.value === 'views') {
            const res = await api.get(`listingsIndexByViews?page=${pageNum.value}`, {
                params: filters,
            });
            listingStore.allListings = res.data.listings;
        }
        if(sortOption.value === 'price-high-to-low') {
            const res = await api.get(`listingsIndexByPrice?page=${pageNum.value}`, {
                params: filters,
            });
            listingStore.allListings = res.data.listings;
        }
        if(sortOption.value === 'price-low-to-high') {
            const res = await api.get(`listingsIndexLowestToHighest?page=${pageNum.value}`, {
                params: filters,
            });
            listingStore.allListings = res.data.listings;
        }
    } catch(err) {
        error.value = error.response?.data?.message || 'failed to get paginated values next page';
    } finally {
        loading.value = false;
    }
}

async function getPreviousPageListings() {
    loading.value = true;
    try {
        pageNum.value--;
        if(sortOption.value === 'recent') {
            const res = await api.get(`listingsRent?page=${pageNum.value}`, {
                params: filters,
            });
            listingStore.allListings = res.data.listings;
        }
        if(sortOption.value === 'views') {
            const res = await api.get(`listingsIndexByViews?page=${pageNum.value}`, {
                params: filters,
            });
            listingStore.allListings = res.data.listings;
        }
        if(sortOption.value === 'price-high-to-low') {
            const res = await api.get(`listingsIndexByPrice?page=${pageNum.value}`, {
                params: filters,
            });
            listingStore.allListings = res.data.listings;
        }
        if(sortOption.value === 'price-low-to-high') {
            const res = await api.get(`listingsIndexLowestToHighest?page=${pageNum.value}`, {
                params: filters,
            });
            listingStore.allListings = res.data.listings;
        }
    } catch(err) {
        error.value = error.response?.data?.message || 'failed to get paginated values next page';
    } finally {
        loading.value = false;
    }
}

</script>
<style scoped>
.container {
    display: flex;
    flex-direction: column;
    width: 100%;

}
.filter-and-listings-container {
    display: flex;
    flex-direction: row;
}
.filter-container {
    display: flex;
    box-shadow: 0 6px 20px rgba(0,0,0,.06);
    height: fit-content;
    flex-direction: column;
    border: 1px solid #FFFFFF;
    width: 22%;
    margin-left: 40px;
    border-radius: 12px;
    background-color: #FFFFFF;
    margin-top: 150px;
}
.filters-header {
    margin-left: 30px;
}
.top-of-filters {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;

}
.reset-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 2px;
}
.reset-filters {
    font-size: 18px;
    margin-right: 30px;
    margin-top: 5px;
    color: #2d6e53;
    cursor: pointer;
}
.reset-img {
    height: 20px;
    cursor: pointer;
}
.filter-topic {
    font-size: 18px;

}
.buy-rent-section {
    display: flex;
    margin-left: 25px;
    flex-direction: column;

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
.price-section {
    display: flex;
    margin-top: 15px;
    margin-left: 30px;
    flex-direction: column;
}
.min-max-row {
    display: flex;
    justify-content: center;
    width: 100%;
    align-items: center;
    gap: 20px;

}
.min-max-input {
    width: 60%;
    height: 55px;
    border-radius: 12px;
    border: 1px solid #F2EFE6;
    font-size: 16px;
    padding-left: 15px;
}
.min-max-input:hover {
    border: 1px solid #FF0000;
}
.icon-buy {
    height: 18px;
    width: 50%;
    background-color: #FDFBD4;
    border-radius: 80%;
    padding: 6px 6px;
}
.icon-rent {
    height: 18px;
    width: 50%;
    padding: 6px 6px;
    background-color: #FDFBD4;
    border-radius: 80%;
}
.county-section {
    display: flex;
    flex-direction: column;
    margin-top: 15px;
    margin-left: 30px;
    width: 100%;
}
.county-select {
    width: 85%;
    height: 50px;
    border: 1px solid #F2EFE6;
    border-radius: 12px;
    cursor: pointer;
    background-color: #FFFFFF;
    font-size: 16px;
    padding-left: 15px;
}
.county-select:hover {
    border: 1px solid #FF0000;
}
.dropdown-value-county {
    font-size: 16px;
    height: 50px;
    border-radius: 12px;
    background-color: #000000;
    color: #FFFFFF;
}
.room-number-selection {
    display: flex;
    flex-direction: column;
    margin-top: 15px;
    margin-left: 30px;
}
.row-of-numbers {
    display: flex;
    flex-direction: row;
    gap: 10px;
    width: 100%;
    padding-right: 10px;
}
.square-num-rooms {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 40px;
    width: 60px;
    border: 1px solid #F2EFE6;
    border-radius: 14px;
    cursor: pointer;
}
.square-num-rooms.active {
    background-color: #2d6e53;
    color: #FFFFFF;
}
.square-num-rooms:hover {
    border: 1px solid #FF0000;
}
.keywords-section {
    display: flex;
    flex-direction: column;
    width: 100%;
    margin-left: 30px;
    margin-top: 15px;
}
.keywords-input {
    width: 85%;
    height: 50px;
    border: 1px solid #F2EFE6;
    border-radius: 12px;
    padding: 0 16px 0 45px;
    font-size: 16px;
}
.keywords-input:hover {
    border: 1px solid #FF0000;
}
.keywords-input-wrapper {
    position: relative;
    width: 100%;

}
.search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);

    width: 20px;
    height: 22px;
}
.button-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;


}
.apply-filters-btn {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
    gap: 3px;
    height: 60px;
    padding: 20px 40px;
    width: 70%;
    font-size: 17px;
    background-color: #2d6e53;
    border: none;
    cursor: pointer;
    margin-bottom: 20px;
    border-radius: 12px;
    color: #FFFFFF;
}
.apply-filters-btn:hover {
    background-color: #1F4D3A;
}
.img-in-btn {
    height: 24px;

}
.rent-listings-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    width: 100%;
    margin: 150px 40px 0 35px;
    align-items: start;
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
