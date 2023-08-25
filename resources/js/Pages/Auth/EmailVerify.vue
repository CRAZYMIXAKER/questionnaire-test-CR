<template>
    <div>
        <div class="mb-4 text-sm text-gray-600">
            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link
            we just emailed to you? If you didn't receive the email, we will gladly send you another.
        </div>

        <div
            v-if="verificationEmailStatus === 'verification-link-sent'"
            class="mb-4 font-medium text-sm text-green-600"
        >
            A new verification link has been sent to the email address you provided during registration.
        </div>

        <div class="mt-4 flex items-center justify-between">
            <button class="form__item" @click="resendVerificationEmail">Resend Verification Email</button>

            <button
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                @click="logout"
            >
                Log Out
            </button>
        </div>
    </div>
</template>

<script setup>
import { useStore } from 'vuex';
import { computed, onMounted } from 'vue';

const store = useStore();

onMounted(() => store.commit('updateVerificationEmailStatus', ''));
const verificationEmailStatus = computed(() => store.getters.verificationEmailStatus);

const resendVerificationEmail = () => {
    axios.post('/api/v1/email/verification-notification')
        .then(response => store.commit('updateVerificationEmailStatus', response.data.status))
        .catch(error => console.log(error));
};
const logout = () => store.dispatch('logout');
</script>
