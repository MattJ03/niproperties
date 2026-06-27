import { ref, reactive, computed } from 'vue';
import { defineStore } from 'pinia';
import api from '../axios.js';
import {local} from "laravel-vite-plugin/fonts";

export const useAuthStore = defineStore('auth', () => {
    const name = ref(localStorage.getItem('name'));
    const token = ref(localStorage.getItem('token'));
    const role = ref(localStorage.getItem('role'));
    const loading = ref(false);
    const error = ref('');

    async function registerLandlord(payload) {
        loading.value = true;
        try {
            const res = await api.post(`registerLandlord`, payload);
            return res.data;
        } catch (error) {
            error.value = error.response?.data?.message || 'error registering as landlord';
        } finally {
            loading.value = false;
        }
    }

    async function registerBuyer(payload) {
        loading.value = true;
        try {
            const res = await api.post(`registerBuyer`, payload);
            return res.data;
        } catch (error) {
            error.value = error.response?.data?.message || 'error registering as buyer';
        }
        finally {
            loading.value = false;
        }
    }

    async function login(payload) {
        loading.value = true;
        try {
            const res =  await api.post(`/login`, payload);
            token.value = res.data.token;
            role.value = res.data.role;
            name.value = res.data.user.name;
            localStorage.setItem('token', token.value);
            localStorage.setItem('role', role.value);
            localStorage.setItem('name', name.value);
        } catch (err) {
            error.value = error.response?.data?.message || 'error logging in';
            throw err;
        } finally {
            loading.value = false;
        }
    }

    return {
        name,
        token,
        role,
        loading,
        error,
        registerLandlord,
        registerBuyer,
        login
    };
});



