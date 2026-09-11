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
        </div>
    </div>
</template>
<script setup>
import { ref, reactive, computed, onMounted } from "vue";
import { useListingStore } from "../stores/ListingStore.js";
import { useUserDirectoryStore } from "../stores/UserDirectoryStore.js";
import Navbar from "../components/Navbar.vue";
import {storeToRefs} from "pinia";

const loading = ref(false);
const error = ref('');

const listingStore = useListingStore();
const userStore = useUserDirectoryStore();
const { listingsCount } = storeToRefs(listingStore);
const { userCount } = storeToRefs(userStore);
const currentMonth = ref('');
const currentYear = ref('');

onMounted(async () => {
    await listingStore.getAllListings();
    await userStore.getTotalUsers();
    getCurrentMonthAndYear();

    console.log(currentMonth.value + ' is the month' + currentYear.value)
});

function getCurrentMonthAndYear() {
    let d = new Date();
    currentMonth.value = d.getMonth();
    currentYear.value = d.getFullYear();
}
console.log(currentMonth.value);
</script>
<style scoped>
.container {
    display: flex;
    width: 100%;
}
.row-of-stats {
    display: flex;
    flex-direction: row;
    height: 15dvh;
    width: 100%;
    gap: 80px;
    margin-top: 180px;
    padding-left: 40px;
}
.analytics-square {
    display: flex;
    flex-direction: column;
    border-radius: 14px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    height: 150px;
    width: 200px;

    border: 1px solid #000000;
}
.analytics-square-title {
    margin-left: 15px;
    margin-top: 10px;
    color: #88807b;
    font-size: 18px;
}
.analytic-square-value {
    display: flex;
    margin: auto;
    font-size: 28px;
    font-weight: bold;
}
</style>
