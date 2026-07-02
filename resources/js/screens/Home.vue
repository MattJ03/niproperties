<template>
    <div class="container">
        <div class="top-container">
        <img :src="house4k" class="top-container-house-img" alt="top-house-image" />
            <div class="hello-user-wrapper">
                <div class="hello-row">
                <h2 class="hello-message">Find your new home</h2>
                <h2 class="hello-message-name" v-if="name"> {{ name }}</h2>
                </div>
                <div class="search-wrapper">
                    <input type="text" v-model="search" class="search-bar"/>
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
    width: 30%;
}
.hello-message {
    color: #FFFFFF;
    z-index: 1;
    position: relative;
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
.search-wrapper {
    z-index: 1;
    position: relative;
    height: 50px;
}
.search-bar {
    position: relative;
    z-index: 1;
    height: 50px;
    width: 100%;
}
</style>
