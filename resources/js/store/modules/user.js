import axios from 'axios';
import router from '@/router/index.js';

export default {
  state: {
    user: null,
    errors: [],
  },
  getters: {
    user(state) {
      return state.user;
    },
    errors(state) {
      return state.errors;
    },
  },
  mutations: {
    updateUser(state, user) {
      state.user = user;
    },
    updateErrors(state, errors) {
      state.errors = errors;
    },
  },
  actions: {
    createUser({ commit }, form) {
      axios.get('/sanctum/csrf-cookie').then(() => {
        axios.post('/api/v1/register', form)
          .then(() => router.push({ name: 'home' }))
          .catch((e) => commit('updateErrors', e.response.data.errors));
      });
    },
    loginUser({ commit }, form) {
      axios.get('/sanctum/csrf-cookie').then(() => {
        axios.post('/api/v1/login', form)
          .then(() => router.push({ name: 'home' }))
          .catch((e) => commit('updateErrors', e.response.data.errors));
      });
    },
    logout() {
      axios.get('/sanctum/csrf-cookie').then(() => {
        axios.post('/api/v1/logout')
          .then(() => router.push({ name: 'login' }))
          .catch((e) => console.log(e));
      });
    },
  },
};
