import '@/bootstrap';
import { createApp } from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import App from '@/App.vue';
import Router from '@/router/router';
import Notifications from '@kyvg/vue3-notification';
import store from '@/store';

const app = createApp(App);
app.use(VueAxios, axios);
app.use(Notifications);
app.use(store);
app.use(Router);
app.mount('#app');
