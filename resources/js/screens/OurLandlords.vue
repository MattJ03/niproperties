<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="landlord-list">
            <div class="top-of-list">
                <span class="landlord-amount-pulled"> 1 - {{ userDirectoryStore.landlords.length }} of {{ userDirectoryStore.landlordCount }} landlords</span>
                <div class="pagination-buttons">
                    <div class="vertical-line"></div>
                    <button class="prev-btn" @click="getPreviousPageLandlords()">Prev</button>
                    <button class="next-btn" @click="getNextPageLandlords()">Next</button>
                </div>
            </div>

            <div class="landlords-section" v-for="landlord in userDirectoryStore.landlords" :key="landlord.id">
                <div class="landlord-info">
                    <img :src="peopleIcon" class="landlord-image" alt="landlord image"/>
                    <span class="landlord-name"> {{ landlord.name }}</span>
                    <span class="number-of-listings">Number of listings: {{ landlord.listings_count}}</span>
                    <button class="view-info-btn" @click="showInfoModal = true; selectedlandlord = landlord" >View info</button>
                </div>
            </div>
        </div>
    </div>
    <div v-if="showInfoModal" class="landlord-modal">
        <div class="modal-square">
            <div class="top-of-modal">

                <button @click="showInfoModal = false; selectedlandlord = null" class="x-btn">
                    <img :src="x" class="close-modal-img" alt="close image"/>
                </button>
            </div>
            <div class="landlord-details-square">
                <img :src="agent" class="landlord-profile-pic" alt="landlord image" />
                <h2 class="landlord-name-square"> {{selectedlandlord.name }}</h2>
                <span class="landlord-text">Landlord</span>
                <div class="horizontal-line-below-landlord"></div>
                <div class="specific-details-wrapper">
                    <img :src="calandar" alt="calander" class="img-in-details" />
                    <div class="text-and-answer">
                    <span class="member-since-text">Member since</span>
                        <span class="member-since-text"> {{ selectedlandlord.created_at }}</span>
                    </div>
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
import api from '../axios.js';
import x from '../assets/x.png';
import agent from '../assets/agent.png';
import calandar from '../assets/calander.png';
import dayjs from "dayjs";
import RelativeTime from 'dayjs/plugin/relativeTime.js';



const userDirectoryStore = useUserDirectoryStore();
const pageNum = ref(1);
const loading = ref(false);
const error = ref('');
const showInfoModal = ref(false);
const selectedlandlord = ref(null);
dayjs.extend(RelativeTime);
const getNextPageLandlords = async () => {
    loading.value = true;
    pageNum.value++;
    try {
        const res = await api.get(`getLandlords?page=${pageNum.value}`);
        userDirectoryStore.landlords = res.data.landlords;
    } catch(err) {
        error.value = error.response?.data?.message || 'failed to next page landlords';
    } finally {
        loading.value = false;
        console.log('pageNum = ' + pageNum.value);
    }
}

const getPreviousPageLandlords = async () => {
    loading.value = false;
    pageNum.value--;
    try {
        const res = await api.get(`getLandlords?page=${pageNum.value}`);
        userDirectoryStore.landlords = res.data.landlords;
    } catch(err) {
        error.value = error.response?.data?.message || 'failed to get previous page landlords';
    } finally {
        loading.value = false;
    }
}

onMounted(() => {
    userDirectoryStore.getLandlords();

});
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
    background-color: #2dcc95;
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
    color: #000000;
    background-color: #2dcc95;
    cursor: pointer;
    border-radius: 12px;
    margin-right: 20px;
    font-size: 15px;
}
.landlord-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background-color: rgba(0,0,0,0.6);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 999;
}
.modal-square {
    display: flex;
    flex-direction: column;
    border-radius: 12px;
    width: 60%;
    height: 75%;

    background-color: #FFFFFF;

}
.landlord-info-header {
    padding: 3px 30px;
}
.top-of-modal {
    display: flex;
    justify-content: end;
    width: 100%;
    height: fit-content;
    background-color: #FFFFFF;
    border-radius: 12px;
}
.x-btn {
    display: flex;
    align-items: center;
    margin-right: 30px;
    background-color: #FFFFFF;
    padding-top: 20px;
    border: none;

}
.close-modal-img {
    height: 36px;
    width: 36px;
    cursor: pointer;
}
.landlord-details-square {
    display: flex;
    align-items: center;
    flex-direction: column;
    width: 30%;
    height: 100%;
    background-color: #FFFFFF;
    border-radius: 12px;
}
.landlord-profile-pic {

    margin-top: 10px;
    height: 120px;
    width: 140px;
    border-radius: 60px;
}
.landlord-name-square {
    font-size: 32px;
    margin-bottom: 15px;
}
.landlord-text {
    color: #65676b;
    font-size: 16px;
}
.horizontal-line-below-landlord {
    border-top: 1px solid #D3D3D3;
    width: 80%;
    margin-top: 30px;
    margin-bottom: 20px;
}
.specific-details-wrapper {
    display: flex;
}
.img-in-details {
    height: 40px;
    width: 40px;
   background-color: #f3f4f6;
    padding: 8px 8px;
    border-radius: 60px;
}
.text-and-answer {
    display: flex;
    padding-left: 10px;
    flex-direction: column;
}
.member-since-text {
    color: #65676b;
}
</style>
