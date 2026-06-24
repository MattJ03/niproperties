import { ref, reactive, computed } from 'vue';
import { defineStore } from 'pinia';
import api from '../axios.js';

export const useAuthStore = defineStore('auth', () => {
    const name = ref(localStorage.getItem('name'));
    const token = ref(localStorage.getItem('token'));
    const role = ref(localStorage.getItem('role'));
    const loading = ref(false);
    const error = ref('');

    async function login(email, password) {
        loading.value = true;
        try {
            const res = api.get('')
        }
    }

});
