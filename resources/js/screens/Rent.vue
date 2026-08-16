<template>
    <Navbar></Navbar>
    <div class="container">
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

</template>
<script setup>
import { ref, reactive, computed, onMounted } from "vue";
import { useListingStore } from "../stores/ListingStore.js";
import Navbar from "../components/Navbar.vue";
import reset from "../assets/reset.png";
import keys from "../assets/keys2.png";
import housesquare from "../assets/housesquare.png";
import search2 from "../assets/search.png";
import scaffolding from "../assets/scaffolding2.png";
import RentGrid from "../components/RentGrid.vue";

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

</script>
<style scoped>
.container {
    display: flex;
    width: 100%;

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
</style>
