<template>
    <div>
        <h1>Registration</h1>
        <div class="form">

            <!-- Name -->
            <div class="mt-4">
                <label for="name">Name</label>
                <input
                    id="name"
                    v-model="form.name"
                    autocomplete="name"
                    autofocus
                    class="block mt-1 w-full"
                    required
                    type="text"
                >
                <label v-if="errors?.name" class="mt-2">{{ errors.name[0] }}</label>
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <label for="email">Email</label>
                <input
                    id="email"
                    v-model="form.email"
                    autocomplete="username"
                    class="block mt-1 w-full"
                    required
                    type="email"
                >
                <label v-if="errors?.email" class="mt-2">{{ errors.email[0] }}</label>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password">Password</label>
                <input
                    id="password"
                    v-model="form.password"
                    autocomplete="new-password"
                    class="block mt-1 w-full"
                    required
                    type="password"
                >
                <label v-if="errors?.password" class="mt-2">{{ errors.password[0] }}</label>
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <label for="password_confirmation">Confirm Password</label>
                <input
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    autocomplete="new-password"
                    class="block mt-1 w-full"
                    required
                    type="password"
                    @keyup.enter="registerUser"
                >
            </div>

            <div class="flex items-center justify-end mt-4">
                <router-link
                    :to="{name: 'login'}"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Already registered?
                </router-link>
                <button class="ml-4" type="button" @click="registerUser">Register</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, reactive } from 'vue';
import { useStore } from 'vuex';
import router from '@/router/index';
import { notify } from '@kyvg/vue3-notification';

const store = useStore();
const form = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

onMounted(() => store.commit('updateErrors', ''));
const errors = computed(() => store.getters.errors);

const registerUser = () => {
    store.dispatch('createUser', form)
        .then(() => {
            router.push({ name: 'home' });
            notify({
                text: 'Thanks for signing up! Before getting started, could you verify your email address by clicking' +
                    ' on the link we just emailed to you?',
                type: 'info',
                speed: 1000,
                duration: 20000,
            });
        });
};
</script>
