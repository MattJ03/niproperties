<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="filter-and-listings-container">
            <div class="filter-container">
                <div class="top-of-container">
                    <h2 class="filter-header">Filters</h2>
                    <div class="reset-wrapper">
                        <img :src="reset" class="reset-img" alt="reset" />
                        <span class="reset-text">Reset Filters</span>
                    </div>
                </div>
                <div class="row">
                    <p class="filter-topic">Price range</p>

                </div>
            </div>
        </div>

    </div>
</template>
<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import Navbar from "../components/Navbar.vue";
import reset from '../assets/reset.png';
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
    flex-direction: column;
    width: 22%;
    border-radius: 12px;
    border: 1px solid #FFFFFF;
    background-color: #FFFFFF;
    margin-top: 150px;
    margin-left: 40px;

}
.top-of-container {
    display: flex;
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
    width: 100%;
    margin-top: 15px
}
.filter-topic {
    margin-left: 30px;
    font-weight: bold;
    font-size: 18px;
}
</style>
