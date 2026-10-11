<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="landlord-header-wrapper">
            <img :src="profilePicture" alt="profile picture" class="profile-picture" />
            <h2 class="landlord-name"> {{  user.name }}</h2>
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
                        <input type="text"  v-model="searchMobile" class="search-input-mobile" placeholder="search..."/>
                    </div>
                </div>
                <div class="filters-wrapper">
                    <button class="apply-filters-btn" @click="applyFilters(landlord.id, filters)">Apply filters</button>
                    <span class="remove-filters-text" @click="removeFilters()">
                      <img :src="reset" class="reset-img" alt="reset"/>
                  Reset Filters
                  </span>
                </div>
            </div>
        </div>

    </div>
</template>
<script setup>
import { ref, reactive, computed, onMounted, watch } from 'vue';
import Navbar from "../components/Navbar.vue";
import profilePicture from "../assets/agent.png";
import search2 from "../assets/search.png";
import reset from "../assets/reset.png";
import { useListingStore } from "../stores/ListingStore.js";
import {useAuthStore} from "../stores/AuthStore.js";
import {storeToRefs} from "pinia";

const loading = ref(false);
const errror = ref('');
const listingStore = useListingStore();
const authStore = useAuthStore();
const { user } = storeToRefs(authStore);
const filters = reactive({
    min_num_rooms: '',
    max_num_rooms: '',
    county: '',
    min_price: '',
    max_price: '',
});
const rooms = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
const search = ref('');
const searchMobile= ref('');

onMounted( async () => {
   await authStore.getCurrentUser();
   await listingStore.getLandlordsListings(authStore.user.id);
});

const counties = ref(['Fermanagh', 'Antrim', 'Tyrone', 'Londonderry', 'Armagh', 'Down']);
</script>
<style scoped>
.container {
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
.search-input-mobile {
    display: none;
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
@media(max-width: 900px) {
    .landlord-header-wrapper {
        margin-top: 100px;
        height: 60px;
        padding-left: 12px;
        gap: 8px;
    }
    .filters-container {
        gap: 8px;
    }


    .header-lower-column {
        display: flex;
        flex-direction: column;
    }
    .landlord-name {
        font-size: 18px;
    }
    .rent-buy-wrapper {
        display: none;
    }
    .field {
        display: none;
    }
    .apply-filters-btn {
        display: none;
    }
    .search-input {
        display: none;
    }
    .search-wrapper {

    }
    .search-input-mobile {
        display: flex;
        border-radius: 14px;
        height: 50px;
        background-color: #f3f4f6;
        border: 1px solid #FFFFFF;
        padding-left: 8px;
        font-size: 16px;
        width: 160px;
    }
    .search-img {
        display: none;
    }
    .remove-filters-text {
        display: none;
    }

}
</style>
