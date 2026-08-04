<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="header-container">
            <div class="header-text-wrapper">
               <h1>Browse Properties</h1>

            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, reactive, computed } from 'vue';
import Navbar from "../components/Navbar.vue";
</script>
<style scoped>
.container {
    display: flex;
    height: 100dvh;
    width: 100%;

}
.header-container {
    display: flex;


    height: 11%;
    width: 100%;
    margin-top: 150px;
    background-color: #FFFFFF;
}
.header-text-wrapper {
    display: flex;
    margin-left: 50px;
    flex-direction: column;
}
</style>
