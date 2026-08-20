<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="landlord-list">
            <div class="top-of-list">
                <span class="landlord-amount-pulled"> 1 - {{ userDirectoryStore.landlords.length }} of {{ userDirectoryStore.landlordCount }} landlords</span>
                <div class="pagination-buttons">
                    <div class="vertical-line"></div>
                    <button class="prev-btn">Prev</button>
                    <button class="next-btn">Next</button>
                </div>
            </div>

            <div class="landlords-section" v-for="landlord in userDirectoryStore.landlords">
                <div class="landlord-info">
                    <img :src="peopleIcon" class="landlord-image" alt="landlord image"/>
                    <span class="landlord-name"> {{ landlord.name }}</span>
                    <span class="number-of-listings">Number of listings: {{ landlord.listings_count}}</span>
                    <button class="view-info-btn">View info</button>
                </div>
            </div>
        </div>

    </div>
</template>
<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import Navbar from "../components/Navbar.vue";
import { useUserDirectoryStore } from "../stores/UserDirectoryStore.js";
import peopleIcon from '../assets/agent.png';
import {useListingStore} from "../stores/ListingStore.js";

const userDirectoryStore = useUserDirectoryStore();
userDirectoryStore.getLandlords();
</script>
<style scoped>
.container {
    display: flex;
    width: 100%;
}
.landlord-list {
    display: flex;
    flex-direction: column;
    margin-top: 170px;
    margin-left: 50px;
    height: 80dvh;
    width: 60%;
    background-color: #FFFFFF;
    border-radius: 12px;
}
.top-of-list {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    border-radius: 14px;
    width: 100%;
    height: 10%;
    background-color: #2d6e53;
}
.landlord-amount-pulled {
    font-size: 16px;
    color: #000000;
    margin-left: 20px;
}
.pagination-buttons {
    display: flex;
    align-items: center;
    height: 100%;
    gap: 10px;
    margin-right: 20px;

}
.vertical-line {
    width: 1px;
    border-left: 1px solid #000000;

    height: 100%;
    color: #000000;
    background-color: #000000;
}
.prev-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    height: 52px;
    width: 80px;
    border-radius: 14px;
    background-color: #FFFFFF;
    border: 1px solid #2d6e53;
    cursor: pointer;
    color: #000000;
}
.prev-btn:hover {
    background-color: #FDFBD4;
}
.next-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    height: 52px;
    width: 80px;
    border-radius: 14px;
    background-color: #FFFFFF;
    color: #000000;
    cursor: pointer;
    padding: 16px 16px;
    border: 1px solid #2d6e53;
}
.next-btn:hover {
    background-color: #FDFBD4;
}

.landlords-section {
    display: flex;
    flex-direction: column;
    margin-top: 30px;
    margin-left: 20px;
    margin-right: 20px;
}
.landlord-info {
    display: flex;
    align-items: center;
    flex-direction: row;
    width: 100%;
    height: 60px;
    border-radius: 14px;
    border: 1px solid #000000;

}
.landlord-image {
    height: 26px;
    width: 28px;
    margin-left: 20px;

}
.landlord-name {
    padding-left: 50px;
    font-size: 18px;
}
.number-of-listings {
    margin-left: 80px;
}
.view-info-btn {
    display: flex;
    align-items: center;
    margin-left: auto;
    height: 80%;
    color: #FFFFFF;
    background-color: #2d6e53;
    cursor: pointer;
    border-radius: 12px;
    margin-right: 20px;
    font-size: 15px;
}
</style>
