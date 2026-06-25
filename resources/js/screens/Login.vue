<template>
    <div class="container">
        <div class="form-card">
           <div class="top-of-log-form">
               <img :src="logo" class="logo-img" alt="logo"/>
               <h2>Log in</h2>
           </div>
            <form @submit.prevent="loginUser()" class="form-fields">
                <div class="form-field">
                <input type="email" v-model="form.email" class="input-field" id="email" placeholder=" "/>
                <label for="email">Email</label>
                    <span class="error-text" v-if="errors.email"> {{ errors.email }}</span>
                </div>
                <div class="form-field">
                    <input type="password" v-model="form.password" class="input-field" id="password" placeholder=" " />
                    <label for="password">Password</label>
                    <span class="error-text" v-if="errors.password"> {{errors.password }}</span>
                </div>
                <button type="submit" class="login-btn">Log in</button>
                <button type="button" @click="moveToRegister()" class="create-account-btn">Create an account</button>
            </form>

        </div>
    </div>
</template>
<script setup>
import logo from '../assets/nipropertieslogo.png';
import { ref, reactive, computed } from "vue";
import { useAuthStore } from "../stores/AuthStore.js";
import { useRouter } from "vue-router";


 const loading = ref(false);
 const error = ref('');
 const form = reactive({
    email: '',
    password: '',
});

 const authStore = useAuthStore();
 const router = useRouter();
 const errors = reactive({
     email: '',
     password: '',
 });

 async function loginUser() {
     if(!validate()) {
         return;
     }
     try {
     await authStore.login(form);
     await router.push({
         name: 'home',
     });
 } catch (err) {
         error.value = error.response?.data?.message || 'Failed to login';
     } finally {
         loading.value = false;
     }
 }

 function validate() {
     let valid = true;

     errors.email = form.email ? '' : 'enter email';
     errors.password = form.password ? '' : 'enter password';
     if(!form.email || !form.password) {
         valid = false;
     }
     return valid;
 }

 async function moveToRegister() {
     loading.value = true;
     try {
         await router.push({
             name: 'register',
         });
     } catch(err) {
         error.value = error.response?.data?.message || 'failed to router to register screen';
     } finally {
         loading.value = false;
     }
 }

</script>
<style scoped>
.container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: auto;
    height: 100dvh;
    width: 100%;
}
.form-card {

    height: 80%;
    width: 32%;
    background-color: #FFFFFF;
    border: 1px solid #FFFFFF;
    border-radius: 14px;
}
.top-of-log-form {
    display: flex;
    justify-content: left;
    flex-direction: row;
    align-items: center;
    gap: 60px;
    padding-top: 10px;
    padding-bottom: 75px;
}
.logo-img {
    height: 18%;
    width: 30%;
}
.form-fields {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 35px;
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
.login-btn {
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
    .login-btn:hover {
        background-color: #2d6e53;
}

.create-account-btn {
    width: 80%;
    padding-top: 15px;
    padding-bottom: 15px;
    border-radius: 30px;
    background-color: #fffffff3;
    color: #1877f2;
    font-size: 15px;
    cursor: pointer;
    border: solid 1px #0064e0;
}
.create-account-btn:hover {
    background-color: #F2EFE6;
}

.error-text {
    display: block;
    font-size: 12px;
    color: #c0392b;
    margin-top: 6px;
    margin-left: 8px;

}
</style>
