import { createApp } from 'vue';
import app from '../views/App.blade.php';
import router from './router/index.js';
import { createPinia } from 'pinia';

const app = createApp(app);

const pinia = createPinia();

app.use(router);
app.use(pinia);
app.mount('#app')
