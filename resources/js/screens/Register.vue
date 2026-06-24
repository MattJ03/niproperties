<template>
    <div class="container">
        <div class="form-container">
            <h2 class="header-reg">Get started on NI Properties</h2>
            <p class="header-mes">Create an account to view properties in Northern ireland and create listings.</p>
            <div class="account-selection">
                <div class="buyer-square" @click="role = 'buyer'">
                    <img :src="key" class="key-img" alt="key-image"/>

                    buyer
                </div>
                <div class="landlord-square" @click="role = 'landlord'">
                    <img :src="home" class="key-img" alt="key-image"/>
                    landlord
                </div>

            </div>
            <div class="error-role-wrapper">
                <span class="field-error" v-if="!role"> {{ error }}</span>
            </div>
            <form @submit.prevent="submitReg()" class="form-card">

                <div class="form-field">
                <input type="text" class="input-field" id="name" v-model="form.name" placeholder=" "/>
                <label for="name">Name</label>
                    <span class="field-error" v-if="errors.name"> {{ errors.name }}</span>
                </div>
                <div class="form-field">
                    <input type="email" class="input-field" id="email" v-model="form.email" placeholder=" "/>
                    <label for="email">Email</label>
                    <span class="field-error" v-if="errors.email"> {{ errors.email }} </span>
                </div>
                <div class="form-field">
                    <input type="tel" class="input-field" id="contact" v-model="form.contact" placeholder=" "/>
                    <label for="contact">Contact number</label>
                    <span class="field-error" v-if="errors.contact"> {{ errors.contact }}</span>
                </div>
                <div class="form-field">
                    <input type="password" class="input-field" id="password" v-model="form.password" placeholder=" "/>
                    <label for="password">Password</label>
                    <span class="field-error" v-if="errors.password"> {{ errors.password }}</span>
                </div>
                <div class="form-field">
                    <input type="password" class="input-field" id="password_confirmation" v-model="form.password_confirmation" placeholder=" "/>
                    <label for="password_confirmation">Re-enter password</label>
                    <span class="field-error" v-if="errors.password_confiration"> {{ errors.password_confiration }}</span>
                </div>
                <button class="submit-btn">Submit</button>
            </form>
        </div>
    </div>

</template>
<script setup>
import { ref, reactive, computed } from 'vue';
import house from '../assets/registerHouse.png';
import home from '../assets/home.png';
import key from '../assets/key.png';
import api from "axios";
import { useAuthStore } from "../stores/AuthStore.js";
import { useRouter } from 'vue-router';

const loading = ref(false);
const error = ref('');
const role = ref('');
const errors = reactive({
   name: '',
   email: '',
   contact: '',
   password: '',
   password_confiration: '',
});

const form = reactive ({
    name: '',
    email: '',
    contact: '',
    password: '',
    password_confirmation: '',
});

const authStore = useAuthStore();
const router = useRouter();

function validate() {
    let valid = true;

    errors.name = form.name ? '' : 'Please enter your name';
    errors.email = form.email ? '' : 'Please enter your email';
    errors.contact = form.contact ? '' : 'Please enter your phone number';
    errors.password = form.password ? '' : 'Please enter a password';
    errors.password_confiration = form.password_confirmation ? '' : 'Please confirm your password';
    if (!form.name || !form.email || !form.contact || !form.password || !form.password_confirmation) {
        valid = false;
    }

    return valid;
}


const submitReg = async () => {
    if(!validate()) {
        return;
    }
    if(!role.value) {
        error.value = 'Please select buyer or landlord';
        return;
    }
    loading.value = true;

    try {
        console.log(role.value);
        if(role.value === 'landlord') {
            await authStore.registerLandlord(form);
        } else if(role.value === 'buyer') {
            await authStore.registerBuyer(form);
        }
        console.log('submitted');
        router.push('/home');
    } catch (error) {
        error.value = error.response?.message || 'error submitting';
    } finally {
        loading.value = false;
    }
}

setTimeout(() => {
    console.log(role.value);
}, 8000);




</script>
<style scoped>
.container {
    display: flex;
    margin-left: 20px;
    margin-right: 20px;
    margin-top: 15px;
    height: 100dvh;

}
.form-container {
    display: flex;
    justify-content: left;
    flex-direction: column;
    background-color: #ffffff;
    height: 85%;
    width: 35%;
    border:  solid 1px #ffffff;
    border-radius: 14px;
    margin-left: 90px;
    margin-top: 60px;
}
.form-card {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    gap: 25px;
    margin-top: 25px;
}
.input-field {
    height: 60px;
    width: 540px;
    border-radius: 14px;
    border: solid 1px #ccd0d5;
    font-size: 16px;
    padding-left: 20px;
}
.input-field:focus {
    outline: none;
    border-color: #1877f2;;
}
.input-field:hover {
    border-color: #1877f2;
}
.form-field {
    position: relative;
}
.form-field label {
    position: absolute;
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 16px;
    color: #65676b;
    pointer-events: none;
    transition: all 0.15s ease;
}

.input-field:focus ~ label,
.input-field:not(:placeholder-shown) ~ label {
    top: 5px;
    transform: translateY(0);
    font-size: 12px;
    color: #1c1e21;

}

.header-reg {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    font-size: 24px;
    padding-top: 22px;
    margin-bottom: 0;
}
.header-mes {
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 15px;
}

.account-selection {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: row;
    width: 85%;
  margin-left: 45px;
    height: 100px;
    gap: 20px;

}
.buyer-square {
    height: 60%;
    width: 20%;
    background-color: #F2EFE6;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 3px;
    border: dotted rgba(72, 86, 242, 0.5);;
    font-size: 18px;
    cursor: pointer;
    border-radius: 12px;
}
.landlord-square {
    display: flex;
    justify-content: center;

    align-items: center;
    height: 60%;
    width: 20%;
    background-color: #F2EFE6;
    font-size: 18px;
    border-radius: 12px;
    border: dotted rgba(72, 86, 242, 0.5);;
    gap: 5px;
    cursor: pointer;
}

.key-img {
    height: 30%;
    width: 20%;
}
.submit-btn {
    width: 80%;
    padding-top: 15px;
    padding-bottom: 15px;
    border-radius: 30px;
    background-color: #0064e0;
    color: #ffffff;
    font-size: 15px;
    cursor: pointer;
    border: none;
}
.submit-btn:hover {

}
.field-error {
    display: block;
    color: #c0392b;
    font-size: 12px;
    margin-top: 6px;
}
.error-role-wrapper {
    display: flex;
    justify-content: center;
    flex-direction: column;
    margin-left: 33%;
    margin-top: 0;
    margin-bottom: 0;
    margin-right: 40%;
}
</style>
