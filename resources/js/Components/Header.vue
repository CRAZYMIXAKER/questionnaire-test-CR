<template>
  <header class="header">
    {{ user }}
    <button v-if="user" @click="logout">Logout</button>
    <!--      <div v-else>-->
    <!--        <router-link v-show="isRegisterRoute" :to="{name: 'register'}">Registration</router-link>-->
    <!--        <router-link v-show="isLoginRoute" :to="{name: 'login'}">Login</router-link>-->
    <!--      </div>-->
    <nav class="header__nav">
      <router-link
          v-for="link in navigationLinks"
          v-show="!isActiveLink(link)"
          :key="link.name"
          :to="{ name: link.name }"
      >
        <!--        v-if="(link?.name === 'login' && !user) || (link?.name === 'register' && !user) || user"-->
        {{ link.label }}
      </router-link>
    </nav>
  </header>
</template>

<script>
import { useStore } from 'vuex';
import { computed } from 'vue';
import { useRoute } from 'vue-router';

export default {
  name: 'Header',
  // isLoginRoute: false,
  // isRegisterRoute: false,
  setup() {
    const store = useStore();
    const route = useRoute();

    const user = computed(() => store.getters.user);
    const logout = () => store.dispatch('logout');
    const isActiveLink = (link) => route.name === link.name;
    const navigationLinks = computed(() => [
      { name: 'home', label: 'Home' },
      { name: 'surveys.index', label: 'Surveys' },
      { name: 'login', label: 'Login' },
      { name: 'register', label: 'Register' },
    ]);

    return {
      user,
      logout,
      isActiveLink,
      navigationLinks
    };
  },
};
</script>
