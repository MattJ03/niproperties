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
            <div class="line-below-pagination"></div>
            <div class="landlords-section">

            </div>
        </div>

    </div>
</template>
<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import Navbar from "../components/Navbar.vue";
import { useUserDirectoryStore } from "../stores/UserDirectoryStore.js";

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
    height: 70dvh;
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

    background-color: #FFFFFF;
    height: 12%;
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
    background-color: #2d6e53;
    border: 1px solid #2d6e53;
    cursor: pointer;
    color: #FFFFFF;
}
.next-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    height: 52px;
    width: 80px;
    border-radius: 14px;
    background-color: #2d6e53;
    cursor: pointer;
    padding: 16px 16px;
    border: 1px solid #2d6e53;

    color: #FFFFFF;
}
.line-below-pagination {
    width: 100%;
    height: 1px;
    background-color: #000000;
}
.landlords-section {

}
</style>
