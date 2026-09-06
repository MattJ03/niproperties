<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="img-wrapepr">

        </div>
    </div>
</template>
<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import Navbar from "../components/Navbar.vue";
import { useListingStore } from "../stores/ListingStore.js";
import { useRoute } from "vue-router";

const loading = ref(false);
const error = ref('');
const listingStore = useListingStore();

onMounted(async () => {
    listingStore.
})
</script>
<style scoped>
.container {
    display: flex;
    width: 100%;

}
</style>
