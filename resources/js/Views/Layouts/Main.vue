<template>
    <div>
        <Header/>
        <div id="main">
            <router-view/>
        </div>
        <div id="sidebar">
            <router-view name="right_menu"/>
        </div>
    </div>
</template>

<script>
import Header from '@/Components/Header.vue';

export default {
    components: { Header },
    data() {
        return {
            user: window.Laravel.user,
        };
    },
};
</script>

