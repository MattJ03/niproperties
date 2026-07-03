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

        </div>
    </nav>
</template>
<script setup>
import { ref, reactive, computed } from 'vue';
import nipropertieslogo from '../assets/nipropertieslogo.png';

</script>
<style scoped>
.nav-bar {
    position: absolute;
    top: 0;
    width: 100%;
    height: 10dvh;
    display: flex;
    flex-direction: row;

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

}
</style>
