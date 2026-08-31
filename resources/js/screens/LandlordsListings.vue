<template>
    <Navbar></Navbar>
  <div class="container">
      <div class="landlord-header-wrapper">
          <img :src="profilePicture" alt="profile picture" class="profile-picture" />
      </div>
  </div>

</template>
<script setup>
import Navbar from "../components/Navbar.vue";
import { useListingStore } from "../stores/ListingStore.js";
import {onMounted} from "vue";
import profilePicture from '../assets/agent.png';

const listingStore = useListingStore();
onMounted(()=> {
    console.log('landlord id ' + listingStore.landlordId);
});
</script>
<style scoped>
.container {
    display: flex;
    width: 100%;
    min-height: 100dvh;
    background-color: #6B46C1;
}
.landlord-header-wrapper {
    display: flex;
    align-items: center;
    margin-top: 150px;
    height: 100px;
    width: 100%;
    margin-left: 20px;
    padding-left: 30px;
    padding-right: 20px;
    margin-right: 20px;
    background-color: #FFFFFF;
    border-radius: 12px;
}
.profile-picture {
    height: 70%;
    cursor: pointer;
    border-radius: 60px;
    padding: 10px 10px;
}
.profile-picture:hover {
    background-color: #F2EFE6;
}
</style>
