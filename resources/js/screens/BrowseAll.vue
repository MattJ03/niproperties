<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="header-container">
            <div class="header-text-wrapper">
               <h1>Browse Properties</h1>
                <span class="total-listings-text">Total listings across Northern Ireland: {{ listingStore.listingsCount }}</span>
            </div>
            <select class="sort-dropdown">
            <option>Sort: Most recent</option>
            </select>
        </div>
    </div>
</template>
<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import Navbar from "../components/Navbar.vue";
import { useListingStore } from "../stores/ListingStore.js";

const loading = ref(false);
const error = ref('');
const listingStore = useListingStore();

onMounted(() => {
    listingStore.getAllListings();
})

</script>
<style scoped>
.container {
    display: flex;
    height: 100dvh;
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
    padding-bottom: 15px;
    background-color: #FFFFFF;
}
.header-text-wrapper {
    display: flex;
    margin-left: 50px;
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
}
</style>
