<template>
    <Navbar></Navbar>
</template>
<script setup>
import { ref, reactive, computed, onMounted } from "vue";
import { useListingStore } from "../stores/ListingStore.js";
import { useUserDirectoryStore } from "../stores/UserDirectoryStore.js";
import Navbar from "../components/Navbar.vue";

const loading = ref(false);
const error = ref('');


const listingStore = useListingStore();
const userStore = useUserDirectoryStore();
</script>
<style scoped>
</style>
