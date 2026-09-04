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
                <p class="filter-topic">Price range</p>
                <div class="row">
                   <input v-model="filters.min_price" type="number" placeholder="min-price" class="min-price-range-box"/>
                    <input v-model="filters.max_price" type="number" placeholder="max-price" class="max-price-range-box"/>

                    </div>
            </div>
        </div>

    </div>
</template>
<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import Navbar from "../components/Navbar.vue";
import reset from '../assets/reset.png';

const filters = reactive({
    min_price: '',
    max_price: '',
    min_num_rooms: '',
    county: '',
});
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
    width: 100%;
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


    margin-left: 30px;
    gap: 15px;

}
.filter-topic {
    margin-left: 30px;
    font-weight: bold;
    font-size: 18px;
}
.min-price-range-box {
    height: 55px;
    width: 45%;
    padding-left: 15px;
    border-radius: 12px;
    border: 1px solid #F2EFE6;
    font-size: 16px;
}
.max-price-range-box {
    height: 55px;
    width: 45%;
    padding-left: 15px;
    border-radius: 12px;
    border: 1px solid #F2EFE6;
    font-size: 16px;
}
</style>
