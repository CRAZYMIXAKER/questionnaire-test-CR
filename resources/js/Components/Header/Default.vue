<template>
    <header class="header">
        <nav
            class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop"
                    class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <ul class="navbar-nav ml-auto">
                <li
                    v-for="link in navigationLinks"
                    :key="link.name"
                    class="nav-item"
                >
                    <router-link
                        v-show="!isActiveLink(link)"
                        :to="{ name: link.name }"
                        class="nav-link"
                    >
                        {{ link.label }}
                    </router-link>
                </li>

                <div class="topbar-divider d-none d-sm-block"></div>

                <template v-if="!user">
                    <li class="nav-item">
                        <router-link
                            v-if="!isRegisterRoute"
                            :to="{name: 'register'}"
                            class="nav-link"
                        >
                            Registration
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link
                            v-if="!isLoginRoute"
                            :to="{name: 'login'}"
                            class="nav-link"
                        >
                            Login
                        </router-link>
                    </li>
                </template>

                <!-- Nav Item - User Information -->
                <li v-else class="nav-item dropdown no-arrow">
                    <a
                        id="userDropdown"
                        aria-expanded="false"
                        aria-haspopup="true"
                        class="nav-link dropdown-toggle"
                        data-toggle="dropdown"
                        href="#"
                        role="button"
                    >
                        <span
                            class="mr-2 d-none d-lg-inline text-gray-600 small"
                        >
                            {{ user.name }}
                        </span>
                        <img
                            class="img-profile rounded-circle"
                            src="img/undraw_profile.svg"
                        >
                    </a>

                    <!-- Dropdown - User Information -->
                    <div
                        aria-labelledby="userDropdown"
                        class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a
                            class="dropdown-item"
                            data-target="#logoutModal"
                            data-toggle="modal"
                            @click="logout"
                        >
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>

            </ul>

        </nav>
    </header>
</template>

<script>
import { useStore } from 'vuex';
import { computed } from 'vue';
import { useRoute } from 'vue-router';

export default {
    name: 'HeaderDefault',
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

<style lang="scss" scoped>
@import "@sass/components/header/default";
</style>
