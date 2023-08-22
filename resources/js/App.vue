<template>
  <div>
    <notifications position="top center"/>
    <router-view/>
  </div>
</template>

<style>
@import "@sass/style.scss";
</style>

<script setup>
import { onMounted } from 'vue';
import { useStore } from 'vuex';

const store = useStore();
const updateUser = (user) => store.commit('updateUser', user);

onMounted(() => updateUser(window.Laravel.user));

Echo.channel('user-updates')
    .listen('UserUpdated', (e) => {
      updateUser(e.user);
    });
</script>
