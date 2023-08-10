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

<style lang="scss">
.header {
    background: lavender;
    padding: 0 30px;

    &__nav {
        column-gap: 10px;
        display: flex;

        a {
            color: cornflowerblue;
            font-size: 20px;
            padding: 20px 10px;
            text-decoration: unset;

            &:hover {
                color: snow;
                background: lightpink;
            }
        }
    }
}
</style>
