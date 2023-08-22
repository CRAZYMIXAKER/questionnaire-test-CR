<template>
  <header class="header">
    <nav class="header__nav">
      <div class="header__nav-main">
        <router-link
            v-for="link in navigationLinks"
            v-show="!isActiveLink(link)"
            :key="link.name"
            :to="{ name: link.name }"
        >
          {{ link.label }}
        </router-link>
      </div>
      <div class="header__nav-auth">
        <button v-if="user" @click="logout">Logout</button>
        <template v-else>
          <router-link v-if="!isRegisterRoute" :to="{name: 'register'}">Registration</router-link>
          <router-link v-if="!isLoginRoute" :to="{name: 'login'}">Login</router-link>
        </template>
      </div>
    </nav>
  </header>
</template>

<script>
import { useStore } from 'vuex';
import { computed } from 'vue';
import { useRoute } from 'vue-router';

export default {
  name: 'Header',
  setup() {
    const store = useStore();
    const route = useRoute();

    const user = computed(() => store.getters.user);
    const logout = () => store.dispatch('logout');

    const isActiveLink = (link) => route.name === link.name;
    const navigationLinks = computed(() => [
      { name: 'home', label: 'Home' },
      { name: 'surveys.index', label: 'Surveys' },
    ]);

    const isLoginRoute = computed(() => route.name === 'login');
    const isRegisterRoute = computed(() => route.name === 'register');

    return {
      user,
      logout,
      isActiveLink,
      navigationLinks,
      isLoginRoute,
      isRegisterRoute,
    };
  },
};
</script>
