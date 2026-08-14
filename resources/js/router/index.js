import { createRouter, createWebHistory } from 'vue-router';
import Register from "../screens/Register.vue";
import Login from "../screens/Login.vue";
import Home from "../screens/Home.vue";
import UploadListing from "../screens/UploadListing.vue";
import BrowseAll from "../screens/BrowseAll.vue";
import Rent from "../screens/Rent.vue";

const routes = [
    { path: '/register', component: Register, name: 'register' },
    { path: '/login', component: Login, name: 'login'},
    { path: '/home', component: Home, name: 'home'},
    { path: '/upload-listing', component: UploadListing, name: 'upload listing'},
    { path: '/browse-all', component: BrowseAll, name: 'browse'},
    { path: 'rent-listings', component: Rent, name: 'rent'},
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
