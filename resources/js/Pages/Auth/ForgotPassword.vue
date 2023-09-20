<template>
    <div>
        <div class="mb-4 text-sm text-gray-600">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset
            link that will allow you to choose a new one.
        </div>

        <div class="form">
            <!-- Email Address -->
            <div>
                <label for="email">Email</label>
                <input
                    id="email"
                    v-model="form.email"
                    autofocus
                    class="block mt-1 w-full"
                    required
                    type="email"/>
                <label v-if="formErrors?.email" class="mt-2">{{ formErrors.email[0] }}</label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <button @click="forgotPassword">Email Password Reset Link</button>
            </div>
        </div>
    </div>
</template>


<script setup>
import axios from 'axios';
import { reactive, ref } from 'vue';
import router from '@/router/router';

const form = reactive({
    email: '',
});
let formErrors = ref([]);

const forgotPassword = () => {
    axios.post('/api/v1/forgot-password', form)
        .then(response => {
            router.push({ name: 'home' });
            this.$notify({
                text: response.data.status,
                type: 'info',
                speed: 1000,
                duration: 5000,
            });
        })
        .catch(errors => formErrors.value = errors.response?.data.errors);
};
</script>
