import { ref, reactive, computed } from 'vue';
import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', () => {
    const name = ref(localStorage.getItem('name'));
    const token = ref(localStorage.getItem('token'));
    const role = ref(localStore.getItem('role'));
})
