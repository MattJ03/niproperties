<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="row-of-stats">
            <div class="analytics-square">
                <span class="analytics-square-title">Total listings</span>
                <span class="analytic-square-value"> {{ listingsCount }}</span>
            </div>
            <div class="analytics-square">
                <span class="analytics-square-title">Total users:</span>
                <span class="analytic-square-value"> {{ userCount }}</span>
            </div>
            <div class="analytics-square">
                <span class="analytics-square-title">Sold propperties this month</span>
                <span v-if="soldListingsMonth" class="analytic-square-value"> {{ soldListingsMonth }}</span>
                <span v-if="!soldListingsMonth" class="analytic-square-value"> 0 </span>
            </div>
            <div class="analytics-square">
                <span class="analytics-square-title">Landlords</span>
                <span class="analytic-square-value"> {{ landlordCount }}</span>
            </div>
            <div class="analytics-square">
                <span class="analytics-square-title">Average rent £</span>
                <span class="analytic-square-value"> {{ formatPrice(averageRent) }}</span>
            </div>
        </div>
        <div class="row">
        <div class="landlords-most-listings-wrapper">
            <span class="top-of-leaderboard-text">Largest portfolios</span>
            <div class="horizontal-line-below-header"></div>
            <div class="landlord-leaderboard">
            <div v-for="landlord in landlordLeaderboard" class="landlord-index-info">
                <div class="landlord-details">
                <img :src="agent" class="agent-pfp" alt="profile picture"/>
                <span> {{ landlord.name }} : </span>
                <span class="total-listings-count"> {{ landlord.listings_count }}</span>
                </div>
                    <div class="horizontal-line-below-entry"></div>
            </div>
        </div>
        </div>
        <div class="listings-most-viewed-wrapper">
            <span class="top-of-leaderboard-text">Most viewed listings</span>
            <div class="horizontal-line-below-header"></div>
        </div>
        </div>
    </div>
</template>
<script setup>
import { ref, reactive, computed, onMounted } from "vue";
import { useListingStore } from "../stores/ListingStore.js";
import { useUserDirectoryStore } from "../stores/UserDirectoryStore.js";
import Navbar from "../components/Navbar.vue";
import { storeToRefs } from "pinia";
import agent from '../assets/agent.png';


const loading = ref(false);
const error = ref('');

const listingStore = useListingStore();
const userStore = useUserDirectoryStore();
const { listingsCount, soldListingsMonth, averageRent } = storeToRefs(listingStore);
const { userCount, landlordCount, landlordLeaderboard } = storeToRefs(userStore);

const currentMonth = ref('');
const currentYear = ref('');
const leaderboardPosition = ref([1, 2, 3, 4, 5]);


onMounted(async () => {
    await listingStore.getAllListings();
    await userStore.getTotalUsers();
    await userStore.getLandlords();
    getCurrentMonthAndYear();
    await listingStore.getListingsSoldThisMonth(currentMonth.value, currentYear.value);
    await listingStore.getAverageRentOfProperties();
    await userStore.getLandlordsWithLargestPortfolios();
});

function getCurrentMonthAndYear() {
    let d = new Date();
    currentMonth.value = d.getMonth();
    currentYear.value = d.getFullYear();
}
console.log(currentMonth.value);

function formatPrice(price) {
    return Intl.NumberFormat('en-GB', {
        style: 'currency',
        currency: 'GBP',
    }).format(price);
}
</script>
<style scoped>
.container {
    display: flex;
    flex-direction: column;
    width: 100%;
}
.row-of-stats {
    display: flex;
    flex-direction: row;
    height: 15dvh;
    width: 100%;
    gap: 80px;
    margin-top: 180px;
    padding-left: 60px;
    margin-bottom: 50px;
}
.analytics-square {
    display: flex;
    flex-direction: column;
    border-radius: 14px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    height: 200px;
    width: 270px;
    background-color: #FFFFFF;
    border: 1px solid #000000;
}
.analytics-square-title {
    margin-left: 15px;
    margin-top: 10px;
    color: #000000;
    font-size: 20px;
}
.analytic-square-value {
    display: flex;
    align-items: center;
    justify-content: center;
    margin: auto;
    font-size: 38px;
    font-weight: bold;
    color: #000000;

}
.row {
    display: flex;
    width: 100%;
   flex-direction: row;
    gap: 80px;
}
.landlords-most-listings-wrapper {
    display: flex;
    flex-direction: column;
    height: 300px;
    border: 1px solid #000000;
    width: 300px;
    border-radius: 0 14px 14px 0;
    margin-top: 60px;
    padding-top: 8px;
    background-color: #FFFFFF;
}
.top-of-leaderboard-text {
    font-size: 22px;
    padding-left: 15px;
}
.horizontal-line-below-header {
    width: 100%;
    margin-top: 15px;
    border-top: 1px solid #000000;
}
.landlord-leaderboard {
    display: flex;
    flex-direction: column;
    padding-top: 20px;
    gap: 20px;

}
.landlord-index-info {
    display: flex;
    flex-direction: column;

    width: 100%;
    font-size: 20px;
}
.landlord-details {
    display: flex;
    justify-content: left;
    flex-direction: row;
    padding-left: 10px;
    margin-bottom: 6px;
}
.agent-pfp {
    height: 24px;
    margin-right: 10px;
    width: 24px;
}

.total-listings-count {
    display: flex;
    margin-left: 10px;
}
.line-wrapper {
    display: flex;
    flex-direction: column;
    width: 100%;
}
.horizontal-line-below-entry {
    border-top: 1px solid #cccccc;
    width: 100%;

}
.listings-most-viewed-wrapper {
    display: flex;
    flex-direction: column;
    height: 300px;
    border: 1px solid #000000;
    width: 300px;
    border-radius: 14px;
    margin-top: 60px;
    padding-top: 8px;
    background-color: #FFFFFF;
}
</style>
