<template>
    <header class="header">
        <nav class="header__nav">
            <router-link
                v-for="link in navigationLinks"
                v-show="!isActiveLink(link)"
                :key="link.name"
                :to="{ name: link.name }"
            >
                {{ link.label }}
            </router-link>
        </nav>
    </header>
</template>

<script>
export default {
    computed: {
        navigationLinks() {
            return [
                { name: 'home', label: 'Home' },
                { name: 'surveys.index', label: 'Surveys' },
            ];
        },
    },
    methods: {
        isActiveLink(link) {
            return this.$route.name === link.name;
        },
    },
};
</script>
