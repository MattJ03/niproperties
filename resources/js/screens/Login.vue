<template>
    <div class="container">
        <div class="form-card">
           <div class="top-of-log-form">
               <img :src="logo" class="logo-img" alt="logo"/>
               <h2>Log in</h2>
           </div>
            <form class="form-fields">
                <div class="form-field">
                <input type="email" class="input-field" id="email" placeholder=" "/>
                <label for="name">Email</label>
                </div>
                <div class="form-field">
                    <input type="password" class="input-field" id="password" placeholder=" " />
                    <label for="password">Password</label>
                </div>
            </form>
        </div>
    </div>
</template>
<script setup>
import logo from '../assets/nipropertieslogo.png';
import { ref, reactive, computed } from "vue";
import { useAuthStore } from "../stores/AuthStore.js";

 const loading = ref(false);
 const error = ref('');
 const form = reactive({
    email: '',
    password: '',
});


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
</style>
