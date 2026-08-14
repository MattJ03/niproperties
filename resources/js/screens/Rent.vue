<template>
    <Navbar></Navbar>

</template>
<script setup>
import { ref, reactive, computed, onMounted } from "vue";
import { useListingStore } from "../stores/ListingStore.js";
import Navbar from "../components/Navbar.vue";

</script>
<style scoped>
</style>
