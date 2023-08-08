<template>
    <header>
        <nav style="display: flex; column-gap: 10px;">
            <router-link v-if="!isHomePage" :to="{ name: 'home' }">Home</router-link>
            <router-link :to="{ name: 'surveys.index' }">Surveys</router-link>
        </nav>
    </header>
</template>

<script>
export default {
    computed: {
        isHomePage() {
            return this.$route.name === 'home';
        },
    },
};
</script>
