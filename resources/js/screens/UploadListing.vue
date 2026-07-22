<template>
    <div class="container">
        <div class="header-group">
        <h1>List a new property</h1>
        <span>You're listing will be reviewed by an admin before being made public. Usual wait is 24 hours or less.</span>
        </div>
        <div class="property-details-card">
            <strong><span class="property-details-header">Property details</span></strong>
            <div class="row-details-address">
                <div class="field">
                    <strong><label class="field-tex">Address line 1</label></strong>
                    <input type="text" v-model="form.first_address_line" class="input-text-address" placeholder="e.g. 4 Malone Road, Belfast">
                </div>
                <div class="field">
                    <strong><label class="field-text">Address line 2</label></strong>
                    <input type="text" v-model="form.second_address_line" class="input-text-address">
                </div>
            </div>
            <div class="row-details">
                <div class="field">
                    <strong><label class="field-text">Town</label></strong>
                <input type="text" v-model="form.town" class="input-text-town" placeholder="Tyrone">
                </div>
                <div class="field">
                    <strong><label class="field-text">County</label> </strong>
                    <select class="county-dropdown" v-model="form.county">
                        <option>Fermanagh</option>
                        <option>Antrim</option>
                        <option>Tyrone</option>
                        <option>Londonderry</option>
                        <option>Armagh</option>
                        <option>Down</option>
                    </select>
                </div>
                <div class="field">
                    <strong><label class="field-text">Postcode</label></strong>
                    <input type="text" v-model="form.postcode" class="input-text-town">
                </div>
                </div>
            <div class="row-details">
                <div class="field">
                <strong><label class="field-text">Price (£)</label></strong>
                <input type="number" v-model="form.price" class="input-text-town">
                </div>
                <div class="field">
                    <strong><label class="field-text">No. of rooms</label></strong>
                    <input type="number" v-model="form.no_of_rooms" class="input-text-town">
                </div>
                <div class="field">
                    <strong><label class="field-text">Rent/Buy</label></strong>
                    <div class="rent-or-buy-button-wrapper">
                    <button class="rent-select-btn" @click="form.type = 'rent'"
                    :class=" { active: form.type === 'rent'}"
                    >Rent</button>
                    <button class="buy-select-btn" @click="form.type = 'buy'"
                    :class=" { active: form.type === 'buy'}"
                    >Buy</button>
                    </div>
                </div>
                </div>
            <div class="row-details">
                <textarea class="description-text" v-model="form.description" placeholder="Leave a short description about the property...">

                </textarea>
            </div>
        </div>
        <div class="attach-card">
            <strong><span class="attach-header">Property photos</span></strong>
            <div class="attach-row">
                <label class="drag-file-wrapper">
                    <input type="file" class="drag-file" multiple accept="image/*" @change="handleFileSelect">
                    <span class="upload-icon">📷</span>
                    <p class="placeholder-title">Drag photos here or click to browse</p>
                    <p class="placeholder-subtext">JPG, PNG, GIF up to 2MB each</p>
                </label>
                <div class="preview-wrapper">
                <div class="preview-box" v-for="(img, index) in images" :key="index">
                   <img :src="img.url" alt="">
                </div>
                </div>
            </div>
            <div class="upload-btn-wrapper">
                <button @click="submitListing" class="upload-btn">Submit listing</button>
            </div>
        </div>
        </div>
</template>
<script setup>
import { ref, reactive, computed } from 'vue';

const form = reactive({
    first_address_line: '',
    second_address_line: '',
    town: '',
    county: '',
    postcode: '',
    price: '',
    no_of_rooms: '',
    type: '',
    description: '',
});

const images = ref([]);
const fileInput = ref(null);

function triggerFileInput() {
    fileInput.value.click();
}

function handleFileSelect(e) {
    for (const file of e.target.files) {
        images.value.push({
            file: file,
            url: URL.createObjectURL(file),
        });
    }
}

</script>
<style scoped>
.container {
    display: flex;
    flex-direction: column;
    height: fit-content;
    width: 100%;

}
.header-group {
    display: flex;
    margin-left: 290px;
    height: fit-content;
    flex-direction: column;

}
.header-group span {
    color: #88807b;
}
.header-group h1 {
    margin-left: 0;
    margin-bottom: 10px;
}
.property-details-card {
    padding-top: 40px;
    display: flex;
    width: 900px;
    flex-direction: column;
    padding-right: 120px;
    padding-left: 40px;
    height: fit-content;
    margin-left: 298px;
    background-color: #FFFFFF;
    margin-top: 40px;
    border-radius: 12px;
}
.property-details-header {
    padding-bottom: 25px;
    font-size: 18px;
}
.row-details-address {
    display: flex;
    margin-bottom: 40px;
    padding-top: 30px;
    width: 100%;
    gap: 80px;
}
.row-details {
    display: flex;

    gap: 40px;
    margin-bottom: 40px;
    width: 100%;
}
.field {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}
.field-text {

}
.input-text-address {
    margin-top: 5px;
    width: 450px;
    height: 50px;
    border: 1px solid #2d6e53;
    border-radius: 16px;
    background-color: #FDFBD4;
    font-size: 16px;
    padding-left: 10px;
}
.input-text-town {
    margin-top: 5px;
    width: 300px;
    height: 50px;
    border: 1px solid #2d6e53;
    border-radius: 16px;
    background-color: #FDFBD4;
    font-size: 16px;
    padding-left: 10px;
}
.county-dropdown {
    height: 50px;
    width: 300px;
    background-color: #FDFBD4;
    border-radius: 16px;
    font-size: 16px;
    padding-left: 10px;
    cursor: pointer;
    box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);
}
.rent-or-buy-button-wrapper {
    display: flex;
    height: 50px;
    width: 200px;
}
.rent-select-btn,
.buy-select-btn {
    width: 100px;
    border-radius: 14px;
    cursor: pointer;
    border: 1.5px solid #2d6e53;
    background-color: transparent;
    font-size: 15px;
    color: #2d6e53;
    font-weight: 500;
    transition: all 0.15s ease;
}

.rent-select-btn.active,
.buy-select-btn.active {
    background-color: #2d6e53;
    color: #FDFBD4;
    border-color: #2d6e53;
}
.description-text {
    width: 100%;
    background-color: #FDFBD4;
    border-radius: 14px;
    height: 130px;
    color: #000000;
    padding-left: 15px;
    padding-top: 5px;
    font-size: 16px;
}
.attach-card {
    display: flex;
    padding-top: 40px;
    width: 900px;
    flex-direction: column;
    padding-right: 120px;
    padding-left: 40px;
    height: 650px;
    margin-left: 298px;
    background-color: #FFFFFF;
    margin-top: 40px;
    border-radius: 12px;
}
.attach-header {
    display: flex;
    font-size: 18px;
    flex-direction: column;
}
.attach-row {
    display: flex;
    flex-direction: column;

}
.drag-file {
    display: flex;
    width: 100%;
    height: 200px;
    border-radius: 14px;
    background-color: #FDFBD4;
}
.drag-file-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 200px;
    border: 2px dashed #2d6e53;
    border-radius: 12px;
    background-color: #FDFBD4;
    cursor: pointer;
    text-align: center;
    width: 100%;
    box-sizing: border-box;
}
.drag-file {
    display: none;
}
.upload-icon {
    font-size: 32px;
}
.placeholder-title {
    margin: 0;
    font-size: 15px;
    font-weight: 500;
    color: #111;
}
.placeholder-subtext {
    margin: 0;
    font-size: 13px;
    color: #88807b;
}
.preview-wrapper {
    display: flex;
    justify-content: center;
    flex-direction: row;
    gap: 20px;
    padding-top: 20px;
}
.preview-box {
    display: flex;
    justify-content: center;
    flex-direction: row;
    width: 120px;
    height: 120px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
}
.preview-box img {
    display: flex;
    flex-direction: row;
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.upload-btn-wrapper {
    display: flex;
    justify-content: center;
    align-content: center;
}
.upload-btn {
    background-color: #2d6e53;
    padding-left: 28px;
    padding-right: 28px;
    padding-top: 24px;
    padding-bottom: 24px;
    border: none;
    color: #FFFFFF;
    border-radius: 14px;
    font-size: 16px;
    cursor: pointer;
    margin-top: 10px;
}
</style>
