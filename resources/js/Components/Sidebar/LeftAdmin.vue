<template>
    <ul
        v-if="isAdmin || isSuperAdmin"
        id="accordionSidebar"
        class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
    >

        <router-link
            :to="{ name: 'home' }"
            class="sidebar-brand d-flex align-items-center justify-content-center"
        >
            <div class="sidebar-brand-text mx-3">Questionnaire</div>
        </router-link>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <li class="nav-item">
            <router-link :to="{ name: '' }" class="nav-link">
                <span>Page?</span>
            </router-link>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Addons
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item active">
            <a
                aria-controls="collapsePages"
                aria-expanded="true"
                class="nav-link"
                data-target="#collapsePages"
                data-toggle="collapse"
                href="#"
            >
                <i class="fas fa-fw fa-folder"></i>
                <span>Pages</span>
            </a>
            <div id="collapsePages" aria-labelledby="headingPages"
                 class="collapse show"
                 data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Surveys:</h6>
                    <router-link
                        :to="{ name: 'admin.surveys.index' }"
                        class="collapse-item"
                    >
                        List
                    </router-link>
                    <router-link
                        :to="{ name: 'admin.surveys.create' }"
                        class="collapse-item"
                    >
                        Create
                    </router-link>

                    <h6 class="collapse-header">Questions:</h6>
                    <router-link
                        :to="{ name: 'admin.questions.index' }"
                        class="collapse-item"
                    >
                        List
                    </router-link>
                    <router-link
                        :to="{ name: 'admin.questions.create' }"
                        class="collapse-item"
                    >
                        Create
                    </router-link>
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button id="sidebarToggle" class="rounded-circle border-0"></button>
        </div>

    </ul>
</template>

<script setup>
import { computed } from 'vue';
import { useStore } from 'vuex';

const store = useStore();
const user = computed(() => store.getters.user);

const isAdmin = user.value?.roleses_name.includes('admin') ?? null;
const isSuperAdmin = user.value?.roleses_name.includes('super-admin') ?? null;
</script>

<style lang="scss" scoped>
@import "@sass/components/sidebars/left-admin";
</style>
