<template>
    <nav class="nav-bar">
        <div class="logo-wrapper">
            <img :src="nipropertieslogo" class="logo" @click="moveToHome()"/>
        </div>
        <div class="headings-selector">
            <strong><span class="headings" @click="moveToBrowseAll()">Browse all</span></strong>
            <strong><span class="headings" @click="moveToRent()">Rent</span></strong>
            <strong><span class="headings">Commercial</span></strong>
            <strong><span class="headings" @click="moveToOurLandlords()">Our landlords</span></strong>
            <strong><span class="headings">Dashboard & Analytics</span></strong>
        </div>
        <div class="btn-section-nav">
            <button class="sell-btn" v-if="role === 'landlord'" @click="moveToUpload()" >
                <img :src="upload" class="upload-img" alt="upload" />
                Upload listing</button>
            <button class="login-btn" v-if="!role" @click="moveToLogin()">
                Log in
            </button>
            <button v-if="authStore.loggedIn" @click="logout()" class="login-btn">Log out</button>
        </div>
    </nav>
</template>
<script setup>
import { ref, reactive, computed } from 'vue';
import nipropertieslogo from '../assets/nipropertieslogo.png';
import { useAuthStore } from "../stores/AuthStore.js";
import { storeToRefs } from "pinia";
import upload from '../assets/upload.png';
import { useRouter } from "vue-router";

const error = ref('');
const authStore = useAuthStore();
const router = useRouter();
const { role } = storeToRefs(authStore);
const loading = ref(false)

const moveToLogin = async () => {
    loading.value = true;
    try {
        await router.push({
            name: 'login',
        });
    } catch(err) {
        error.value = error.response?.data?.message || 'failed to move to login';
    } finally {
        loading.value = false;
    }
}

const moveToUpload = async () => {
    loading.value = true;
    try {
        await router.push({
            name: 'upload listing',
        });
    } catch (err) {
        error.value = error.response?.data?.message || 'failed to move to upload';
    } finally {
        loading.value = false;
    }
}

const moveToHome = async () => {
    loading.value = true
    try {
         router.push({
            name: 'home',
        });
    } catch (err) {
        error.value = error.response?.data?.message || 'failed to go home';
    } finally {
        loading.value = false;
    }
}

const moveToBrowseAll = async () => {
    loading.value = true;
    try {
        await router.push({
            name: 'browse',
        });
    } catch(err) {
        error.value = error.response?.data?.message || 'failed to move to browse';
    }
    finally {
        loading.value = false;
    }
}

const moveToRent = async () => {
    loading.value = true;
    try {
        await router.push({
            name: 'rent',
        });
    } catch(err) {
        error.value = error.response?.data?.nessage || 'failed to move to rent';
    } finally {
        loading.value = false;
    }
}

const moveToCommercial = async () => {
    loading.value = true;
    try {
        await router.push({
            name: ''
        })
    }
}

const moveToOurLandlords = async () => {
    loading.value = true;
    try {
        await router.push({
            name: 'our landlords',
        });
    } catch (err) {
        error.value = error.response?.data?.message || 'failed to move to our landlords';
    } finally {
        loading.value = false;
    }
}
const logout = async() => {
    loading.value = true;
    try {
       await authStore.logout();
       await router.push({
           name: 'login',
       });
    } catch (err) {
        error.value = error.response?.data?.message || 'failed to move to login';
    } finally {
        loading.value = false;
    }
}
</script>
<style scoped>
.nav-bar {
    position: absolute;
    top: 0;
    width: 100%;
    height: 11dvh;
    display: flex;
    flex-direction: row;
    align-items: center;
    z-index: 100;
    padding-left: 40px;
    background-color: #FFFFFF;
    margin-bottom: 40px;
}
.logo-wrapper {

}
.logo {
    height:  108px;
    cursor: pointer;

}
.headings-selector {
    display: flex;
    justify-content: center;
    width: 100%;
    align-items: center;
    gap: 20px;
}

.headings {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    padding: 8px 16px;
    border-radius: 16px;
    background-color: #2dcc95;
    color: #000000;
    font-size: 17px;
    font-weight: bold;
    cursor: pointer;
    white-space: nowrap;
    transition: background-color 0.2s ease;
}

.headings:hover {
    background-color: #553C9A;
}
.btn-section-nav {
    display: flex;
    justify-content: right;

    flex-direction: row;
    padding-bottom: 40px;
    padding-top: 50px;
    gap: 30px;
    margin-right: 100px;

}
.sell-btn {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 6px;
    font-size: 16px;
    font-weight: 500;
    border: 0;
    border-radius: 10px;
    padding-top: 18px;
    padding-bottom: 18px;
    padding-right: 12px;
    padding-left: 12px;
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
.login-btn {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 6px;
    font-size: 16px;
    font-weight: 500;
    border: 0;
    border-radius: 10px;
    padding-top: 18px;
    padding-bottom: 18px;
    padding-right: 12px;
    padding-left: 12px;
    background-color: #E7CBA6;
    color: #1F4D3A;
    cursor: pointer;
    line-height: 1;
    text-wrap: nowrap;
}
</style>
