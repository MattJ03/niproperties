<template>
    <div class="container">
        <div class="form-container">
            <div class="form-card">
                <div class="form-field">
                <input type="text" class="input-field" id="name" placeholder=" "/>
                <label for="name">Name</label>
                </div>
            </div>
        </div>
    </div>

</template>
<script setup>
import { ref, reactive, computed } from 'vue';
import house from '../assets/registerHouse.png';


const form = reactive({
    name: String,
    email: String,
    contact: String,

});
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
    background-color: #ffffff;
    height: 70%;
    width: 35%;
    border:  solid 1px #ffffff;
    border-radius: 14px;
    margin-left: 90px;
    margin-top: 100px;
}
.form-card {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: auto;
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
    top: 10px;
    transform: translateY(0);
    font-size: 12px;
    color: #1c1e21;
}
</style>
