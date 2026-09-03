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
                    <button class="view-info-btn" @click="showInfoModal = true; selectedlandlord = landlord; listingStore.getLandlordsRecentListings(selectedlandlord.id)" >View info</button>
                </div>
            </div>

        </div>

    </div>
    <div v-if="showInfoModal" class="landlord-modal">
        <div class="modal-square">
            <div class="landlord-details-square">
                <img :src="agent" class="landlord-profile-pic" alt="landlord image" />
                <h2 class="landlord-name-square"> {{selectedlandlord.name }}</h2>
                <span class="landlord-text">Landlord</span>
                <div class="horizontal-line-below-landlord"></div>

                <div class="specific-details-wrapper">
                    <div class="landlord-stats">
                    <img :src="calandar" alt="calander" class="img-in-details" />
                    <div class="text-and-answer">
                    <span class="member-since-text">Member since</span>
                        <span class="member-since-answer"> {{ dayjs(selectedlandlord.created_at).format('DD/MM/YYYY') }}</span>
                    </div>
                    </div>
                <div class="landlord-stats">
                    <img :src="house" class="home-img-in-details" alt="house" />
                    <div class="text-and-answer">
                    <span class="member-since-text">Properties listed</span>
                    <span class="member-since-answer"> {{ selectedlandlord.listings_count}}</span>
                    </div>
                    </div>
                    <div class="landlord-stats">
                        <img :src="mail" class="home-img-in-details" alt="mail"/>
                        <div class="text-and-answer">
                            <span class="member-since-text">Email</span>
                            <span class="member-since-answer"> {{ selectedlandlord.email }}</span>
                        </div>
                    </div>
                    <div class="landlord-stats">
                        <img :src="phone" class="home-img-in-details" alt="phone" />
                        <div class="text-and-answer">
                            <span class="member-since-text">Phone number</span>
                            <span class="member-since-answer"> {{ selectedlandlord.contact }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="description-and-listings-container">
                <div class="close-modal">
                    <img :src="x" alt="close button" class="close-btn" @click.self="showInfoModal = false"/>
                </div>
            <div class="landlord-description-wrapper">
                <h3 class="about-header">About {{ selectedlandlord.name }}</h3>
                <p class="landlord-description">Ill do this later</p>
                <div class="horizontal-line-below-about"></div>
            </div>
            <div class="listings-wrapper">
                <div class="listings-header">
                <h3 class="about-header">Their properties</h3>
                    <button class="view-all-btn" @click="moveToLandlordsListings()">View all properties</button>
                </div>
                <div class="listings-row">
                    <ListingGridLandlord
                        v-for="listing in listingStore.landlordsRecentListings"
                        :listing="listing"
                        :key="listing.id"
                        />
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
import router from "../router/index.js";
import peopleIcon from '../assets/agent.png';
import {useListingStore} from "../stores/ListingStore.js";
import api from '../axios.js';
import x from '../assets/x.png';
import agent from '../assets/agent.png';
import calandar from '../assets/calander.png';
import dayjs from "dayjs";
import RelativeTime from 'dayjs/plugin/relativeTime.js';
import house from '../assets/home.png';
import mail from '../assets/mail.png';
import phone from '../assets/phone.png';
import ListingGridLandlord from "../components/ListingGridLandlord.vue";

const userDirectoryStore = useUserDirectoryStore();
const pageNum = ref(1);
const loading = ref(false);
const error = ref('');
const showInfoModal = ref(false);
const selectedlandlord = ref(null);
dayjs.extend(RelativeTime);
const listingStore = useListingStore();



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

const moveToLandlordsListings = async() => {
    loading.value = true;

    listingStore.landlordId = selectedlandlord.value.id;
    try {
        await router.push({
            name: 'landlords listings',
            params: { landlordId: selectedlandlord.value.id },
        });
    }
        catch(err) {
            error.value = error.response?.data?.message || 'failed to move to landlords listings';
        } finally {
            loading.value = false;
        }

}
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
    background-color: #f3f4f6;
    border: 1px solid #f3f4f6;
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
    border: 1px solid #f3f4f6;
    cursor: pointer;
    color: #000000;
}
.prev-btn:hover {
    background-color: #2dcc95;
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
    color: #000000;
    cursor: pointer;
    padding: 16px 16px;
    border: 1px solid #f3f4f6;
}
.next-btn:hover {
    background-color: #2dcc95;
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
    background-color: #f3f4f6;
    border: 1px solid #f3f4f6;

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
    background-color: #2dcc95;
    cursor: pointer;
    border-radius: 12px;
    margin-right: 20px;
    color: #f3f4f6;
    font-size: 15px;
}
.view-info-btn:hover {
    background-color: #2d6e53;
}
.pagination-wrapper {
    display: flex;
    align-items: center;

    flex-direction: row;
    width: 100%;
    height: 80px;
    background-color: #f3f4f6;
    border-radius: 12px;
}
.nav-btn-wrapper {
    display: flex;
    align-items: center;
    justify-content: right;
    gap: 10px;
    height: 100%;
    width: 100%;
}
.previous-btn {
    display: flex;
    gap: 4px;
    color: #6B46C1;
    align-items: center;
    justify-content: center;
    height: 50%;
    padding: 2px 10px;
    background-color: #f3f4f6;
    border: 1px solid #6B46C1;
    border-radius: 12px;
    cursor: pointer;
    font-size: 16px;
}
.current-page {
    display: flex;
    padding: 10px 14px;
    border: 1px solid #6B46C1;
    border-radius: 12px;
}
.landlord-modal {
    position: fixed;
    flex-direction: row;
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
    flex-direction: row;
    border-radius: 12px;
    width: 55%;
    height: 75%;

    background-color: #FFFFFF;

}
.landlord-info-header {
    padding: 3px 30px;
}
.top-of-modal {
    display: flex;
    justify-content: right;
    flex-direction: row;
    width: 10%;
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
.landlord-details-square {
    display: flex;
    align-items: center;
    flex-direction: column;
    width: 30%;
    height: 100%;
    background-color: #F2EFE6;
    border-radius: 12px;
}
.landlord-profile-pic {
    margin-top: 10px;
    height: 120px;
    width: 140px;
    border-radius: 60px;
}
.landlord-name-square {
    word-break: break-all;
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
    flex-direction: column;
}
.landlord-stats {
    display: flex;
    margin-bottom: 30px;
    flex-direction: row;
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
    padding-left: 15px;
    flex-direction: column;
}
.member-since-text {
    display: flex;
    padding-bottom: 10px;
    color: #65676b;
}
.member-since-answer {
    color: #000000;
}
.home-img-in-details {
    height: 30px;
    width: 30px;
    background-color: #f3f4f6;
    padding: 10px 10px;
    border-radius: 40px;
}
.description-and-listings-container {
    display: flex;
    width: 100%;
    flex-direction: column;
    margin-right: 30px;
}
.close-modal {
    display: flex;
    width: 100%;
    flex-direction: row;
    justify-content: right;
    margin-top: 30px;
    margin-bottom: 0;


}
.landlord-description-wrapper {
    display: flex;
    flex-direction: column;
    margin-left: 40px;
    margin-top: 20px;
    width: 100%;
}
.about-header {
    font-size: 23px;
}
.landlord-description {
    color: #65676b;
}
.horizontal-line-below-about {
    border-top: 1px solid #65676b;

    width: 80%;
    margin-top: 20px;
}
.listings-wrapper {
    margin-left: 40px;
    margin-top: 20px;
}
.listings-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    flex-direction: row;
}
.view-all-btn {
    display: flex;
    align-items: center;
    height: 45px;
    border-radius: 12px;
    background-color: #FFFFFF;
    border: 1px solid #65676b;
    padding-top: 5px;
    padding-bottom: 5px;
    color: #2d6e53;
    cursor: pointer;
}
.view-all-btn:hover {
    background-color: #F0F0F0;
}
.listings-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    width: 90%;
}
.close-btn {
    height: 40px;
    cursor: pointer;
}
</style>
