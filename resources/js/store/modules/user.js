import axios from 'axios';
import router from '@/router/router';
import { notify } from '@kyvg/vue3-notification';

export default {
    state: {
        user: null,
        verificationEmailStatus: '',
        errors: [],
    },
    getters: {
        user(state) {
            return state.user;
        },
        verificationEmailStatus(state) {
            return state.verificationEmailStatus;
        },
        errors(state) {
            return state.errors;
        },
    },
    mutations: {
        updateUser(state, user) {
            state.user = user;
        },
        updateVerificationEmailStatus(state, verificationEmailStatus) {
            state.verificationEmailStatus = verificationEmailStatus;
        },
        updateErrors(state, errors) {
            state.errors = errors;
        },
    },
    actions: {
        createUser({ commit }, form) {
            axios.get('/sanctum/csrf-cookie')
                .then(() => {
                    axios.post('/api/v1/register', form)
                        .then(() => {
                            router.push({ name: 'home' });
                            notify({
                                text: 'Thanks for signing up! Before getting started, could you verify your email address by clicking' +
                                    ' on the link we just emailed to you?',
                                type: 'info',
                                speed: 1000,
                                duration: 20000,
                            });
                        })
                        .catch((e) => commit('updateErrors', e.response.data.errors));
                });
        },
        loginUser({ commit }, form) {
            axios.get('/sanctum/csrf-cookie')
                .then(() => {
                    axios.post('/api/v1/login', form)
                        .then(() => router.push({ name: 'home' }))
                        .catch((e) => commit('updateErrors', e.response.data.errors));
                });
        },
        logout() {
            axios.get('/sanctum/csrf-cookie')
                .then(() => {
                    axios.post('/api/v1/logout')
                        .then(() => router.push({ name: 'login' }))
                        .catch((e) => console.log(e));
                });
        },
    },
};
