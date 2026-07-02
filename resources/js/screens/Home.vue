<template>
    <div class="container">
        <div class="top-container">
        <img :src="house4k" class="top-container-house-img" alt="top-house-image" />
            <div class="hello-user-wrapper">
                <div class="hello-row">
                <h2 class="hello-message">Find your new home</h2>
                    <h2 class="hello-message-name" v-if="name"> {{ name }}</h2>
                </div>
                    <div class="type-of-home-selection">
                        <div class="selection-background">
                            <strong><span>Buy</span></strong>
                        </div>
                        <div class="selection-background">
                            <strong><span>Rent</span></strong>
                        </div>
                        <div class="selection-background">
                            <strong><span>Commercial</span></strong>
                        </div>
                </div>
                <div class="search-wrapper">
                    <input type="text" v-model="search" class="search-bar" placeholder="what are you looking for..."/>
                    <button class="search-btn">Search</button>
                </div>
            </div>

        </div>
    </div>

</template>
<script setup>
import { ref, reactive, computed, onMounted } from "vue";
import house4k from '../assets/house4k.jpg';
import { useAuthStore } from "../stores/AuthStore.js";
import { storeToRefs } from "pinia";

const authStore = useAuthStore();

const {role, name} = storeToRefs(authStore);
const search = ref('');


</script>
<style scoped>
.container {
    display: flex;
    width: 100%;
    min-height: 200dvh;
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
    padding-left: 30px;
    padding-right: 30px;
    font-size: 20px;
    gap: 50px;
    padding-top: 30px
}
.type-of-home-selection span {
    color: #FFFFFF;
}
.selection-background {

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
    cursor: pointer;
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
</style>
