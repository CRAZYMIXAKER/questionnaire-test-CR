import './bootstrap';

import { createApp } from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import App from '@/App.vue';
import router from '@/router/index';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken;

const app = createApp(App);
app.use(router);
app.use(VueAxios, axios);
app.mount('#app');
