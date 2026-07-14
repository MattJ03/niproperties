<template>
    <div class="container">
        <div class="header-group">
        <h1>List a new property</h1>
        <span>You're listing will be reviewed by an admin before being made public. Usual wait is 24 hours or less.</span>
        </div>
        <div class="property-details-card">
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
                <input type="text" v-model="form.town" class="input-text-town">
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
                    <input type="number" v-model="form.no_of_rooms" class="input-text-town"
                </div>
                <div class="field">
                    <strong><label class="field-text">Rent/Buy</label></strong>
                    <div class="rent-or-buy-button-wrapper">
                    <button class="rent-select-btn">Rent</button>
                    <button class="buy-select-btn">Buy</button>
                    </div>
                </div>
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
});
</script>
<style scoped>
.container {
    display: flex;
    flex-direction: column;

    height: 100dvh;
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
    padding-top: 80px;
    display: flex;
    width: 900px;
    flex-direction: column;
    padding-right: 120px;
    padding-left: 40px;
    height: 40dvh;
    margin-left: 298px;
    background-color: #FFFFFF;
    margin-top: 40px;
    border-radius: 12px;


}
.row-details-address {
    display: flex;
    margin-bottom: 40px;
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

}

</style>
