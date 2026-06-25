<template>
    <div class="container">
        <div class="form-container">
            <div class="top-of-form">
                <img :src="niproperties" class="logo-img" alt="logo" />
            <h2 class="header-reg">Get started on NI Properties</h2>
            </div>
            <p class="header-mes">Create an account to view properties in Northern ireland and create listings.</p>
            <div class="account-selection">
                <div class="buyer-square"
                     :class="{ active: role === 'buyer'}"
                     @click="role = 'buyer'">
                    <img :src="key" class="key-img" alt="key-image"/>

                    buyer
                </div>
                <div class="landlord-square"
                     :class="{ active: role === 'landlord'}"
                     @click="role = 'landlord'">
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
                <button @click="moveToLogin()" class="login-btn">Already have an account</button>
            </form>
        </div>
        <div class="image-container">
            <img :src="house" class="large-image" alt="house"/>
        </div>
    </div>

</template>
<script setup>
import { ref, reactive, computed } from 'vue';
import house from '../assets/registerHouse.png';
import home from '../assets/home.png';
import niproperties from '../assets/nipropertieslogo.png';
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

const moveToLogin = async () => {
    loading.value = true;
    try {
       await router.push({
            name: 'login'
        });
    } catch (error) {
        error.value = error.response?.data?.message || 'failed to move to login screen';
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
    gap: 60px;
    max-width: 1600px;
    margin: 0 auto;
    padding: 30px;
    min-height: 100vh;

}
.form-container {
    display: flex;
    justify-content: left;
    flex-direction: column;
    background-color: #ffffff;
    height: 85%;
    width: 45%;
    border:  solid 1px #ffffff;
    border-radius: 14px;
    margin-left: 90px;
    margin-top: 60px;
    padding-bottom: 30px;
}
.form-card {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    gap: 25px;
    padding-left: 30px;
    padding-right: 30px;
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
    border-color: #1F4D3A;;
}
.input-field:hover {
    border-color: #1F4D3A;
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
    font-size: 24px;
    margin: 0;
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
    border: solid 1px #000000;
    font-size: 18px;
    cursor: pointer;
    border-radius: 12px;
}
.buyer-square:hover {
    border-color: #1F4D3A;
    transition: 0.3s;
}
.buyer-square.active {
    background-color: #1F4D3A;
    border-color: #1F4D3A;
}
.buyer-square.active span,
.buyer-square.active {
    color: #FFFFFF;
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
    border: 1px solid #000000;
    gap: 5px;
    cursor: pointer;
}
.landlord-square:hover {
    background-color: #1877f2;
    transition: 0.3s;
}
.landlord-square.active span,
.landlord-square.active {
    background-color: #1F4D3A;
    color: #FFFFFF;
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
    background-color: #1F4D3A;
    color: #ffffff;
    font-size: 15px;
    cursor: pointer;
    border: none;
}
.submit-btn:hover {
     background-color: #005AC9;
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
.login-btn {
    width: 80%;
    padding-top: 15px;
    padding-bottom: 15px;
    border-radius: 30px;
    background-color: #fffffff3;
    color: #0064e0;
    font-size: 15px;
    cursor: pointer;
    border: solid 1px #0064e0;
}
.login-btn:hover {
    background-color:#F2EFE6;
}
.top-of-form {
    display: flex;
    justify-content: left;
    align-items: center;
    flex-direction: row;
   margin-top: 20px;

}

.logo-img {

    width: 140px;
}

.image-container {
  height: 100dvh;
    margin-top: 80px;

}
.large-image {
   height: 80%;
    object-fit: cover;
   width: 100%;
    border-radius: 12px;
}
</style>
