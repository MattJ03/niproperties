<template>
    <Navbar></Navbar>
    <div class="container">

    </div>
</template>
<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import Navbar from "../components/Navbar.vue";
</script>
<style scoped>
.container {
    display: flex;
    width: 100%;
}
</style>
