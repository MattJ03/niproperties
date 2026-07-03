<template>
    <nav class="nav-bar">
        <div class="logo-wrapper">
            <img :src="nipropertieslogo" class="logo" />
        </div>
        <div class="headings-selector">
            <strong><span>Browse all</span></strong>
            <strong><span>Buy</span></strong>
            <strong><span>Commercial</span></strong>
            <strong><span>Dashboard & Analytics</span></strong>
        </div>
        <div class="btn-section-nav">
            <button class="sell-btn" v-if="role === 'buyer'" >
                <img :src="upload" class="upload-img" alt="upload" />
                Upload listing</button>
            <button class="login-btn" v-if="role">
                Log in
            </button>
        </div>
    </nav>
</template>
<script setup>
import { ref, reactive, computed } from 'vue';
import nipropertieslogo from '../assets/nipropertieslogo.png';
import { useAuthStore } from "../stores/AuthStore.js";
import { storeToRefs } from "pinia";
import upload from '../assets/upload.png';

const authStore = useAuthStore();

const { role } = storeToRefs(authStore);
</script>
<style scoped>
.nav-bar {
    position: absolute;
    top: 0;
    width: 100%;
    height: 15dvh;
    display: flex;
    flex-direction: row;
    align-items: center;
    z-index: 100;
    padding-left: 40px;
}
.logo-wrapper {

}
.logo {
    height: 108px;

}
.headings-selector {
    display: flex;
    justify-content: center;
    align-items: center;
    padding-left: 500px;

}
.headings-selector span {
    font-size: 17px;
    cursor: pointer;
    padding-right: 50px;
    color: #FFFFFF;
}
.headings-selector span:hover {
    color: #1F4D3A;
}
.btn-section-nav {
    display: flex;
    justify-content: flex-end;
    flex-direction: row;
    padding-bottom: 40px;
    padding-top: 50px;
    gap: 30px;

}
.sell-btn {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    font-weight: 500;
    border: 0;
    border-radius: 8px;
    padding: 10px 16px;
    background-color: #E7CBA6;
    color: #1F4D3A;
    cursor: pointer;
    line-height: 1;

}
.upload-img {
    height: 16px;
    width: 16px;
    padding-right: 0;
    object-fit: contain;
    color: #FFFFFF;
}
</style>
