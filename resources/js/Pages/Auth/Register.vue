<!--<template>-->
<!--    <div>-->
<!--        <h1>Registration</h1>-->
<!--        <div class="form">-->

<!--            &lt;!&ndash; Name &ndash;&gt;-->
<!--            <div class="mt-4">-->
<!--                <label for="name">Name</label>-->
<!--                <input-->
<!--                    id="name"-->
<!--                    v-model="form.name"-->
<!--                    autocomplete="name"-->
<!--                    autofocus-->
<!--                    class="block mt-1 w-full"-->
<!--                    required-->
<!--                    type="text"-->
<!--                >-->
<!--                <label v-if="errors?.name" class="mt-2">{{ errors.name[0] }}</label>-->
<!--            </div>-->

<!--            &lt;!&ndash; Email Address &ndash;&gt;-->
<!--            <div class="mt-4">-->
<!--                <label for="email">Email</label>-->
<!--                <input-->
<!--                    id="email"-->
<!--                    v-model="form.email"-->
<!--                    autocomplete="username"-->
<!--                    class="block mt-1 w-full"-->
<!--                    required-->
<!--                    type="email"-->
<!--                >-->
<!--                <label v-if="errors?.email" class="mt-2">{{ errors.email[0] }}</label>-->
<!--            </div>-->

<!--            &lt;!&ndash; Password &ndash;&gt;-->
<!--            <div class="mt-4">-->
<!--                <label for="password">Password</label>-->
<!--                <input-->
<!--                    id="password"-->
<!--                    v-model="form.password"-->
<!--                    autocomplete="new-password"-->
<!--                    class="block mt-1 w-full"-->
<!--                    required-->
<!--                    type="password"-->
<!--                >-->
<!--                <label v-if="errors?.password" class="mt-2">{{ errors.password[0] }}</label>-->
<!--            </div>-->

<!--            &lt;!&ndash; Confirm Password &ndash;&gt;-->
<!--            <div class="mt-4">-->
<!--                <label for="password_confirmation">Confirm Password</label>-->
<!--                <input-->
<!--                    id="password_confirmation"-->
<!--                    v-model="form.password_confirmation"-->
<!--                    autocomplete="new-password"-->
<!--                    class="block mt-1 w-full"-->
<!--                    required-->
<!--                    type="password"-->
<!--                    @keyup.enter="registerUser"-->
<!--                >-->
<!--            </div>-->

<!--            <div class="flex items-center justify-end mt-4">-->
<!--                <router-link-->
<!--                    :to="{name: 'login'}"-->
<!--                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"-->
<!--                >-->
<!--                    Already registered?-->
<!--                </router-link>-->
<!--                <button class="ml-4" type="button" @click="registerUser">Register</button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</template>-->

<template>
    <div>
        <h1>Registration</h1>

        <div class="form">
            <div class="form-row">
                <!-- Name -->
                <div class="col-md-4">
                    <label for="name">Name</label>
                    <input
                        id="name"
                        v-model="form.name"
                        :class="{'is-invalid': errors?.name}"
                        autocomplete="name"
                        autofocus
                        class="form-control"
                        required
                        type="text"
                    >
                    <label v-if="errors?.name" class="invalid-feedback">{{ errors.name[0] }}</label>
                </div>
            </div>
            <div class="form-row">
                <!-- Email Address -->
                <div class="col-md-4">
                    <label for="email">Email</label>
                    <input
                        id="email"
                        v-model="form.email"
                        :class="{'is-invalid': errors?.email}"
                        autocomplete="username"
                        class="form-control"
                        required
                        type="email"
                    >
                    <label v-if="errors?.email" class="invalid-feedback">{{ errors.email[0] }}</label>
                </div>
            </div>
            <div class="form-row">
                <!-- Password -->
                <div class="col-md-4">
                    <label for="password">Password</label>
                    <input
                        id="password"
                        v-model="form.password"
                        :class="{'is-invalid': errors?.password} "
                        autocomplete="new-password"
                        class="form-control"
                        required
                        type="password"
                    >
                    <label v-if="errors?.password" class="invalid-feedback">{{ errors.password[0] }}</label>
                </div>
            </div>
            <div class="form-row">
                <!-- Confirm Password -->
                <div class="col-md-4">
                    <label for="password_confirmation">Confirm Password</label>
                    <input
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        autocomplete="new-password"
                        class="form-control"
                        required
                        type="password"
                        @keyup.enter="registerUser"
                    >
                </div>
            </div>
            <div class="form-row">
                <div class="d-flex justify-content-between col-md-4 mb-3">
                    <router-link
                        :to="{name: 'login'}"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Already registered?
                    </router-link>
                    <button class="btn btn-primary" @click="registerUser">Register</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, reactive } from 'vue';
import { useStore } from 'vuex';

const store = useStore();
const form = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

onMounted(() => store.commit('updateErrors', ''));
const errors = computed(() => store.getters.errors);

const registerUser = () => {store.dispatch('createUser', form);};
</script>
