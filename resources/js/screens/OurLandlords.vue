<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="landlord-list">
            <div class="top-of-list">
                <span class="landlord-amount-pulled"> {{ userDirectoryStore.landlordCount }} of 30 landlords</span>
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
    margin-top: 170px;
    margin-left: 50px;
    height: 70dvh;
    width: 60%;
    background-color: #FFFFFF;
    border-radius: 12px;
}
</style>
