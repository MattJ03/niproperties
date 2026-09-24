<template>
    <nav class="nav-bar">
        <div class="logo-wrapper">
            <img :src="nipropertieslogo" class="logo" @click="moveToHome()"/>
        </div>
        <div class="headings-selector">
            <strong><span class="headings" @click="moveToBrowseAll()">Browse all</span></strong>
            <strong><span class="headings" @click="moveToRent()">Rent</span></strong>
            <strong><span class="headings" @click="moveToCommercial()">Commercial</span></strong>
            <strong><span class="headings" @click="moveToOurLandlords()">Our landlords</span></strong>
            <strong><span class="headings" @click="moveToDashboard()">Dashboard & Analytics</span></strong>
        </div>
        <div class="btn-section-nav">
            <button class="sell-btn" v-if="role === 'landlord'" @click="moveToUpload()" >
                <img :src="upload" class="upload-img" alt="upload" />
                Upload listing</button>
            <button @click="settingsOpen = true; authStore.getCurrentUser()" class="settings-btn">
            <img :src="settings" class="settings-img" alt="settings" />
                <span>Settings</span>
            </button>
            <button class="login-btn" v-if="!role" @click="moveToLogin()">
                Log in
            </button>
            <button v-if="authStore.loggedIn" @click="logout()" class="login-btn">Log out</button>
        </div>
        <div v-if="settingsOpen === true" class="settings-wrapper">
            <div class="top-of-wrapper">
            <h2 class="settings-header">Settings</h2>
                <img @click="settingsOpen = false" :src="whiteX" class="close-img" alt="whiteX">
        </div>
            <div class="horizontal-line-settings"></div>
            <div class="user-details">
              <span class="user-initial"> {{ initial }}</span>
                <div class="user-email-and-name">
                    <span class="user-name"> {{ user.name }} </span>
                    <span class="user-email"> {{ user.email }}</span>

                </div>
            </div>
            <div class="horizontal-line-settings"></div>
            <div class="landlord-settings">
                <span class="secondary-header">Account</span>
                <div class="settings-selection-row" @click="editProfileModal = true">
                    <img :src="agent" class="agent-img" alt="agent"/>
                    <span>Edit profile</span>
                </div>
                <div class="security-selection-row">
                    <img :src="lock" class="lock-img" alt="lock"/>
                    <span>Password & security</span>
                </div>
                <span class="secondary-header-preferences">Preferences</span>
                <div class="notifications-row">
                    <img :src="bell" class="bell-img" alt="bell"/>
                    <span>Email notifications</span>
                    <label class="switch">
                        <input type="checkbox">
                               <span class="slider round"></span>
                    </label>
                </div>
                <div class="language-row">
                    <img :src="language" class="language-img" alt="language"/>
                    <span>Change language</span>
                </div>
            </div>
        </div>
    </nav>

    <div v-if="editProfileModal === true" class="modal-overlay">
        <div class="edit-profile-square">
            <div class="top-of-square-row">
                <span class="modal-title-text">Edit profile</span>
                <img @click="closeModal(); authStore.getCurrentUser()" :src="x" class="close-modal" alt="close modal"/>
            </div>
            <div class="horizontal-line-settings"></div>
            <div class="profile-photo-row">
                <img :src="agent2" class="edit-profile-photo" alt="pfp"/>
                <button class="change-photo-btn">Change photo</button>
                <span class="remove-photo-text">Remove photo</span>
            </div>
            <div class="edit-profile-row">
                <div class="field">
                    <span class="field-name">Name</span>
                    <input v-model="formDraft.name" type="text" class="name-field"/>
                </div>
                <div class="field">
                    <span class="field-name">Email</span>
                    <input v-model="formDraft.email" type="email" class="name-field" />
                </div>
            </div>
            <div class="edit-profile-row">
                <div class="field">
                    <span class="field-name">Contact number</span>
                    <input type="number" v-model="formDraft.contact" class="name-field" />
                </div>
                <div class="field">
                    <span class="field-role">Role</span>
                    <span class="role-text"> {{ authStore.role }}</span>
                    <div class="not-allowed-box">Unable to change account role</div>
                </div>
            </div>
            <div class="edit-profile-row">
                <div class="field">
                    <span class="field-name">Enter current password</span>
                    <input type="password" v-model="current_password" class="name-field" />
                </div>
            </div>
            <div class="bottom-square">
            <div class="buttons-update-wrapper">
                <button class="update-profile" @click="updateAccount()">Save changes</button>
                <span class="reset-profile" @click="resetEditProfileConfiguration()">Reset</span>
            </div>
        </div>
            </div>
    </div>
</template>
<script setup>
import {ref, reactive, computed, onMounted, watch } from 'vue';
import nipropertieslogo from '../assets/nipropertieslogo.png';
import { useAuthStore } from "../stores/AuthStore.js";
import { storeToRefs } from "pinia";
import upload from '../assets/upload.png';
import { useRouter } from "vue-router";
import settings from '../assets/settings.png';
import whiteX from'../assets/whiteX.png';
import { useUserDirectoryStore } from "../stores/UserDirectoryStore.js";
import agent from '../assets/whiteAgent.png';
import lock from '../assets/whiteLock.png';
import bell from '../assets/bell.png';
import language from '../assets/language.png';
import x from '../assets/x2.png';
import agent2 from '../assets/agent.png';


const error = ref('');
const authStore = useAuthStore();
const router = useRouter();
const { role } = storeToRefs(authStore);
const loading = ref(false)
const settingsOpen = ref(false);
const userStore = useUserDirectoryStore();
const { landlord } = storeToRefs(userStore);
const { user } = storeToRefs(authStore);
const initial = localStorage.getItem('name').charAt(0).toUpperCase();
const editProfileModal = ref(false);
const current_password = ref('');
const errorText = ref('');
const formDraft = ref({ ... user.value});
const errors = reactive({
    name: '',
    email: '',
    contact: '',
    password: '',
});
watch(user, (newUser) => {
    formDraft.value = {... newUser };
})
const moveToLogin = async () => {
    loading.value = true;
    try {
        await router.push({
            name: 'login',
        });
    } catch(err) {
        error.value = error.response?.data?.message || 'failed to move to login';
    } finally {
        loading.value = false;
    }
}

const moveToUpload = async () => {
    loading.value = true;
    try {
        await router.push({
            name: 'upload listing',
        });
    } catch (err) {
        error.value = error.response?.data?.message || 'failed to move to upload';
    } finally {
        loading.value = false;
    }
}

const moveToHome = async () => {
    loading.value = true
    try {
         router.push({
            name: 'home',
        });
    } catch (err) {
        error.value = error.response?.data?.message || 'failed to go home';
    } finally {
        loading.value = false;
    }
}

const moveToBrowseAll = async () => {
    loading.value = true;
    try {
        await router.push({
            name: 'browse',
        });
    } catch(err) {
        error.value = error.response?.data?.message || 'failed to move to browse';
    }
    finally {
        loading.value = false;
    }
}

const moveToRent = async () => {
    loading.value = true;
    try {
        await router.push({
            name: 'rent',
        });
    } catch(err) {
        error.value = error.response?.data?.nessage || 'failed to move to rent';
    } finally {
        loading.value = false;
    }
}

const moveToCommercial = async () => {
    loading.value = true;
    try {
        await router.push({
            name: 'commercial',
        });
    } catch(err) {
        error.value = error.response?.data?.message || 'failed to move to commercial';
    } finally {
        loading.value = false;
    }
}

const moveToOurLandlords = async () => {
    loading.value = true;
    try {
        await router.push({
            name: 'our landlords',
        });
    } catch (err) {
        error.value = error.response?.data?.message || 'failed to move to our landlords';
    } finally {
        loading.value = false;
    }
}
const logout = async () => {
    loading.value = true;
    try {
       await authStore.logout();
       await router.push({
           name: 'login',
       });
    } catch (err) {
        error.value = error.response?.data?.message || 'failed to move to login';
    } finally {
        loading.value = false;
    }
}

const moveToDashboard = async () => {
    loading.value = true;
    try {
        await router.push({
            name: 'dashboard',
        });
    } catch(err) {

    } finally {
        loading.value = false;
    }
}

const updateAccount = async () => {
    loading.value = true;
    try {
        await authStore.updateUserAccount({
            name: formDraft.value.name,
            email: formDraft.value.email,
            contact: formDraft.value.contact,
            password: current_password.value,
        });
        current_password.value = '';
        editProfileModal.value = false;
       await authStore.getCurrentUser();
    } catch(err) {
        error.value = error.response?.data?.message || 'failed to update user account';
    } finally {
        loading.value = false;
    }
}

const resetEditProfileConfiguration = async () => {
    loading.value = false;
    try {
        await authStore.getCurrentUser();
    } catch(err) {

    }
    finally {
        loading.value = false;

    }
}

function passwordCheck() {
    let valid = true;
    errors.name = formDraft.value.name.trim() ? '' : 'name cannot be null';
    errors.email = formDraft.value.email.trim() ? '' : 'email cannot be null';
    errors.contact = formDraft.value.contact.trim() ? '' : 'contact cannot be null';
    errors.password = current_password.value.trim() ? '' : 'password cannot be null';

    if(!formDraft.value.name || !formDraft.value.email || !formDraft.value.contact || !current_password.value) {
        valid = false;
    }
    return valid;
}


const closeModal = () => {
    formDraft.value = user.value;
    editProfileModal.value = false;
}

onMounted( async () => {
    await authStore.getCurrentUser();
});

</script>
<style scoped>
.nav-bar {
    position: absolute;
    top: 0;
    width: 100%;
    height: 11dvh;
    display: flex;
    flex-direction: row;
    align-items: center;
    z-index: 100;
    padding-left: 40px;
    background-color: #FFFFFF;
    margin-bottom: 40px;
}
.logo-wrapper {

}
.logo {
    height:  108px;
    cursor: pointer;

}
.headings-selector {
    display: flex;
    justify-content: center;
    width: 100%;
    align-items: center;
    gap: 20px;
}

.headings {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    padding: 8px 16px;
    border-radius: 16px;
    background-color: #2dcc95;
    color: #000000;
    font-size: 17px;
    font-weight: bold;
    cursor: pointer;
    white-space: nowrap;
    transition: background-color 0.2s ease;
}

.headings:hover {
    background-color: #553C9A;
}
.btn-section-nav {
    display: flex;
    justify-content: right;

    flex-direction: row;
    padding-bottom: 40px;
    padding-top: 50px;
    gap: 30px;
    margin-right: 100px;

}
.sell-btn {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 6px;
    font-size: 16px;
    font-weight: 500;
    border: 0;
    border-radius: 10px;
    padding-top: 18px;
    padding-bottom: 18px;
    padding-right: 12px;
    padding-left: 12px;
    background-color: #E7CBA6;
    color: #1F4D3A;
    cursor: pointer;
    line-height: 1;
}
.sell-btn:hover {
    background-color: #CCB89D;
}
.upload-img {
    height: 16px;
    width: 16px;
    padding-right: 0;
    object-fit: contain;
    color: #FFFFFF;
}
.login-btn {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 6px;
    font-size: 16px;
    font-weight: 500;
    border: 0;
    border-radius: 10px;
    padding-top: 18px;
    padding-bottom: 18px;
    padding-right: 12px;
    padding-left: 12px;
    background-color: #E7CBA6;
    color: #1F4D3A;
    cursor: pointer;
    line-height: 1;
    text-wrap: nowrap;
}
.login-btn:hover {
    background-color: #CCB89D;
}
.settings-btn {
    display: flex;
    align-items: center;
    padding-top: 18px;
    padding-bottom: 18px;
    padding-right: 12px;
    padding-left: 12px;
    background-color: #E7CBA6;
    gap: 6px;
    color: #1F4D3A;
    cursor: pointer;
    border-radius: 10px;
    border: 0;
}
.settings-btn:hover {
    background-color: #CCB89D;
}
.settings-btn span {
    font-size: 16px;
}
.settings-img {
    height: 20px;
}
.settings-wrapper {
    position: fixed;
    right: 0;
    top: 0;
    height: 100dvh;
    min-width: 320px;
    background-color: #2a2f2c;

}
.top-of-wrapper {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    padding: 15px 18px;
    color: #FFFFFF;
}
.settings-header {

}
.close-img {
    height: 26px;
    padding: 8px 8px;
    border-radius: 60px;
    background-color: #2d6e53
}
.close-img:hover {
    cursor: pointer;
    background-color: #CCB89D;
}
.horizontal-line-settings {
    width: 100%;
    border-top: 1px solid #88807b;
}
.user-details {
    display: flex;
    padding: 26px 18px;
    flex-direction: row;
}
.user-initial {
    font-size: 24px;
    padding: 12px 18px;
    background-color: #eeb462;
    border-radius: 60px;
}
.user-email-and-name {
    display: flex;
    flex-direction: column;
    margin-left: 10px;
    gap: 4px;
}
.user-name {
    color: #FFFFFF;
}
.user-email {
    color: #88807b;
}
.landlord-settings {
    padding: 26px 18px;

}
.secondary-header {
    color: #88807b;
}
.settings-selection-row {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 0px;
    cursor: pointer;

}

.settings-selection-row span {
    color: #FFFFFF;
}
.agent-img {
    height: 24px;
    width: 24px;
}
.lock-img {
    height: 24px;
    width: 22px;
}
.security-selection-row {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #FFFFFF;
    margin-bottom: 26px;
    margin-top: 12px;
}
.secondary-header-preferences {

    color: #88807b;
}
.notifications-row {
    display: flex;
    align-items: center;
    margin-top: 12px;
    gap: 8px;
    flex-direction: row;
}
.notifications-row:hover {

}
.notifications-row span {
    color: #FFFFFF;
}
.bell-img {
    height: 22px;
    width: 22px;
}
.switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 26px;
    margin-left: 56px;
}
.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}
.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 16px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
}

input:checked + .slider {
    background-color: #2196F3;
}

input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}

.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}
.language-row {
    display: flex;
    flex-direction: row;
    gap: 8px;

    margin-top: 26px;
}
.language-row span {
    color: #FFFFFF;
}
.language-img {
    height: 22px;
    width: 22px;
}
.modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        background-color: rgba(0,0,0,0.6);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        width: 100vw;
        overflow: hidden;
        z-index: 65;
}
.edit-profile-square {
    display: flex;
    flex-direction: column;
    height: 550px;
    width: 700px;
    background-color: #FFFFFF;
    border: 1px solid #FFFFFF;
    border-radius: 12px;
}
.top-of-square-row {
    display: flex;
    width: 100%;
    justify-content: space-between;
    align-items: center;
   margin-top: 25px;
    margin-bottom: 20px;

}
.modal-title-text {
    font-size: 22px;
    padding-left: 20px;
}
.close-modal {
    height: 24px;
    padding: 8px 8px;
    margin-right: 20px;
}
.close-modal:hover {
    cursor: pointer;
    background-color: #cccccc;
    border-radius: 60px;
}
.profile-photo-row {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 20px;
    width: 100%;
    margin-top: 25px;
    padding-right: 20px;
    padding-left: 20px;
}
.edit-profile-photo {
    height: 55px;
    padding: 12px 12px;
    border-radius: 60px;
    background-color: #E7CBA6;
}
.change-photo-btn {
    height: 40px;
    width: fit-content;
    text-wrap: nowrap;
    border-radius: 10px;
    background-color: #2dcc95;
    border: none;
    color: #1F4D3A;
    cursor: pointer;
    font-size: 15px;
}
.remove-photo-text {
    cursor: pointer;
}
.edit-profile-row {
    display: flex;
    width: 100%;
    gap: 15px;
    margin-top: 25px;
    padding-left: 15px;
    padding-right: 15px;
}
.field {
    display: flex;
    flex-direction: column;
    width: 45%;
    position: relative;

}
.name-field {
    height: 50px;
    border-radius: 10px;
    background-color: #000000;
    padding-left: 6px;
    color: #FFFFFF;
    margin-top: 3px;
    font-size: 16px;
}
.field-role {

}
.role-text {
    display: flex;
    position: relative;
    align-items: center;
    height: 50px;
    border-radius: 10px;
    background-color: #000000;
    padding-left: 6px;
    color: #FFFFFF;
    margin-top: 3px;
    font-size: 16px;
}
.role-text:hover {
    cursor: not-allowed;
}
.not-allowed-box {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    width: fit-content;
    font-size: 16px;
    margin-top: 3px;
    z-index: 99;
    background-color: #333;
    color: #fff;
    padding: 6px 12px;
    border-radius: 4px;
    white-space: nowrap;
}
.role-text:hover + .not-allowed-box {
    display: block;
}
.horizontal-line-edit-profile {
    width: 100%;
    border-top: 1px solid #88807b;
    margin-top: 25px;
}
.bottom-square {
    width: 100%;
    height: 100%;
}
.buttons-update-wrapper {
    display: flex;
    flex-direction: row;
    align-items: center;
    height: 100%;
   gap: 10px;
    justify-content: right;
    margin-right: 25px;

}
.update-profile {
    background-color: #2dcc95;
    height: 48px;
    width: fit-content;
    font-size: 16px;
    color: #2d6e53;
    border-radius: 10px;
    text-wrap: nowrap;
}
.update-profile:hover {
    cursor: pointer;
    background-color: #2d6e53;
    color: #FFFFFF;
}
.reset-profile {
    cursor: pointer;
}
</style>
