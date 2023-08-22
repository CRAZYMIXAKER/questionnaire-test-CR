import '@/bootstrap';
import { createApp } from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import App from '@/App.vue';
import router from '@/router/index';
import Notifications from '@kyvg/vue3-notification';
import store from '@/store';

const app = createApp(App);
app.use(VueAxios, axios);
app.use(Notifications);
app.use(store);
app.use(router);
app.mount('#app');
