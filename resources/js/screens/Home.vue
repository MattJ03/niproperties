<template>
    <Navbar>
    </Navbar>
    <div class="container">
        <div class="top-container">
        <img :src="house4k" class="top-container-house-img" alt="top-house-image" />
            <div class="hello-user-wrapper">
                <div class="hello-row">
                <h2 class="hello-message">Find your new home</h2>
                    <h2 class="hello-message-name" v-if="name"> {{ name }}</h2>
                </div>

                <div class="search-wrapper">
                    <input type="text" v-model="search" class="search-bar" placeholder="what are you looking for..."/>
                    <button class="search-btn">Search</button>
                </div>

                <div class="type-of-home-selection">
                    <div class="message-below-search">
                        <p>Popular searches</p>
                    </div>
                    <div class="row-of-popular-searches">
                    <div class="selection-background">
                        <img :src="location" class="popular-icons" />
                        <strong><span class="popular-search-text">Belfast</span></strong>
                    </div>
                    <div class="selection-background">
                        <img :src="priceTag" class="popular-icons" />
                        <strong><span class="popular-search-text">Under £200,000</span></strong>
                    </div>
                    <div class="selection-background">
                        <img :src="keys" class="popular-icons" />
                        <strong><span class="popular-search-text">Rent</span></strong>
                    </div>
                    <div class="selection-background">
                        <img :src="briefcase" class="popular-icons" />
                        <strong><span class="popular-search-text">Commercial properties</span></strong>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="info-container">
            <div class="message-trusted-wrapper">
                <p class="trusted-header">Trusted across Northern Ireland</p>
                <strong><p class="message-trusted">Making property simple</p></strong>
            </div>
            <div class="row-info-squares">
               <div class="-info-square">
                   <div class="square-image-wrapper">
                       <img :src="ireland" class="square-image" alt="square image ireland" />
                   </div>
                   <div class="info-in-square">
                       <strong><span>Listings in all 6 counties</span></strong>
                       <p class="smaller-text-in-square">Find hundreds of properties all across the 6 counties of Northern Ireland.</p>
                       <div class="bottom-square">
                       <span class="bottom-of-square-text">View locations</span>
                           <img :src="rightarrow" class="bottom-square-icon" alt="right arrow" />
                       </div>
                   </div>
               </div>
                <div class="-info-square">
                    <div class="square-image-wrapper">
                        <img :src="homesquare" class="square-image" alt="home image"/>
                    </div>
                    <div class="info-in-square">
                        <strong><span>Over 3000 sales as of 2026</span></strong>
                        <p class="smaller-text-in-square">Thousands of houses to choose from, to meet any possible need.</p>
                        <div class="bottom-square">
                            <span class="bottom-of-square-text">Browse Properties</span>
                            <img :src="rightarrow" class="bottom-square-icon" alt="right arrow" />
                        </div>
                    </div>
                </div>
                <div class="-info-square">
                    <div class="square-image-wrapper">
                        <img :src="agent" class="square-image" alt="agent image"/>
                    </div>
                    <div class="info-in-square">
                        <strong><span>Trusted vendors</span></strong>
                        <p class="smaller-text-in-square">Vendors have to be approved before being able to list their properties.</p>
                      <div class="bottom-square">
                          <span class="bottom-of-square-text">View Landlords</span>
                          <img :src="rightarrow" class="bottom-square-icon" alt="right arrow"/>
                      </div>
                    </div>
                </div>
                <div class="-info-square">
                    <div class="square-image-wrapper">
                        <img :src="shield" class="square-image" alt="shield"/>
                    </div>
                    <div class="info-in-square">
                        <strong><span>Verified listings</span></strong>
                        <p class="smaller-text-in-square">Listings are approved by admins before being posted on NI properties.</p>
                        <div class="bottom-square">
                            <span class="bottom-of-square-text">View About section</span>
                            <img :src="rightarrow" class="bottom-square-icon" alt="right arrow"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="recent-uploads-container">
            <div class="row-recent-uploads">
                <RecentListing

                />
            </div>
        </div>
    </div>

</template>
<script setup>
import { ref, reactive, computed, onMounted } from "vue";
import house4k from '../assets/house4k.jpg';
import { useAuthStore } from "../stores/AuthStore.js";
import { storeToRefs } from "pinia";
import Navbar from "../components/Navbar.vue";
import location from '../assets/img.png';
import priceTag from '../assets/price_tag.png';
import briefcase from '../assets/briefcase.png';
import keys from '../assets/keys.png';
import ireland from '../assets/ireland.png';
import rightarrow from '../assets/rightarrow.png';
import homesquare from '../assets/housesquare.png';
import agent from '../assets/agent.png';
import shield from '../assets/shield.png';
import RecentListing from "../components/RecentListing.vue";

const authStore = useAuthStore();

const { role, name} = storeToRefs(authStore);
const search = ref('');


</script>
<style scoped>
.container {
    display: flex;
    width: 100%;
    min-height: 200dvh;
    flex-direction: column;
}

.top-container {
    display: flex;
    width: 100%;
    height: 100dvh;
    overflow: hidden;
    position: relative;
}

.top-container-house-img {

    position: absolute;
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    z-index: 0;
}
.hello-user-wrapper {
    display: flex;
    flex-direction: column;
    margin: auto;
    width: 35%;
    padding-bottom: 70px;
}
.hello-message {
    color: #FFFFFF;
    z-index: 1;
    position: relative;
    flex-direction: row;
}
.hello-message-name {
    z-index: 1;
    position: relative;
    color: #FFFFFF;
    padding-left: 4px;
}
.hello-row {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: row;
}
.type-of-home-selection {
    display: flex;
    z-index: 1;
    position: relative;
   justify-content: center;
    align-items: center;
    flex-direction: column;

    padding-left: 30px;
    padding-right: 30px;
    font-size: 20px;
    padding-top: 30px
}
.type-of-home-selection span {
    color: #FFFFFF;
}
.selection-background {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 3px;
    padding-left: 10px;
    padding-right: 10px;
    padding-top: 12px;
    padding-bottom: 12px;
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.35);
    border-radius: 10px;
    color: #FFFFFF;
}
.selection-background:hover {
    border-bottom: 5px solid #1F4D3A;
    transition: 0.3s;
    cursor: pointer;
}
.search-wrapper {
    display: flex;
    flex-direction: row;
    z-index: 1;
    position: relative;
    height: 50px;
    padding-top: 30px;
    margin-right: 0;
}
.search-bar {
    position: relative;
    z-index: 1;
    height: 66px;
    width: 100%;
    border-radius: 30px 0px 0px 30px;
    border: none;
    padding-left: 16px;
    font-size: 16px;
}
.search-bar:hover {
    background-color: #F2EFE6;
    cursor: text;
}
.search-btn {
    display: flex;
    z-index: 1;
    position: relative;
    justify-content: center;
    align-items: center;
    height: 66px;
    background-color: #1F4D3A;
    color: #FFFFFF;
    font-size: 16px;
    width: 15%;
    cursor: pointer;
    border-radius: 0px 30px 30px 0px;
    padding-right: 20px;
    border: none;
}
.search-btn:hover {
    background-color:  #2d6e53;
}
.popular-search-text {
    z-index: 1;
    font-size: 16px;
    white-space: nowrap;
}
.popular-icons {
    height: 16px;
}
.message-below-search {
    display: flex;
    justify-content: center;
    align-items: center;

    z-index: 1;
    position: relative;
    margin: auto;
    color: #D3D3D3;
}
.row-of-popular-searches {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: row;
    gap: 30px;
}
.info-container {
    display: flex;
    width: 100%;
    height: 100dvh;
    overflow: hidden;
    flex-direction: column;
    z-index: 1;
    position: relative;

}
.trusted-header {
    font-size: 18px;
    color: #2d6e53;
}
.message-trusted-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;


}
.message-trusted {
    font-size: 40px;
}
.row-info-squares {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: row;
    width: 100%;
    gap: 30px;

}
.-info-square {
    display: flex;
    justify-content: left;
    border-radius: 12px;
    flex-direction: column;
    height: fit-content;
    padding-bottom: 40px;
    padding-right: 40px;
    padding-left: 15px;
    width: 20%;
    border: none;
    z-index: 1;
    background-color: #FFFFFF;

}
.square-image-wrapper {
    display: flex;
    justify-content: left;
    align-items: center;

    width: fit-content;
    height: fit-content;

    margin-left: 30px;
    margin-top: 40px;

    background-color: #FDFBD4;
    border-radius: 80px;


}
.square-image {
    height: 44px;
    padding: 8px 8px;

}
.info-in-square {
    display: flex;
    justify-content: left;
    padding-top: 30px;
    font-size: 20px;
    margin-left: 16px;
    flex-direction: column;
}
.smaller-text-in-square {
    color: #A9A9A9;
}
.bottom-square {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: auto;
    cursor: pointer;
}
.bottom-of-square-text {
    color: #2d6e53;
    padding-top: 20px;
    font-size: 18px;
}
.bottom-square-icon {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 30px;
    height: 40px;
    padding-top: 20px;
    padding-left: 10px;
}
.recent-uploads-container {
    display: flex;
    justify-content: center;
    align-items: center;
}
.row-recent-uploads {
    display: flex;
    flex-direction: row;
}
</style>
