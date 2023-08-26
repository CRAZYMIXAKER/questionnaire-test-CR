<template>
    <div>
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
            />
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
            />
            <label v-if="errors?.password_confirmation" class="mt-2">{{ errors.password_confirmation[0] }}</label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <button @click="resetPassword">Reset Password</button>
        </div>
    </div>
</template>

<script setup>
import { notify } from '@kyvg/vue3-notification';
import { useRouter } from 'vue-router';
import { reactive, ref } from 'vue';

const router = useRouter();

const form = reactive({
    token: router.currentRoute.value.params.token,
    email: router.currentRoute.value.query.email,
    password: '',
    password_confirmation: '',
});
const errors = ref([]);

const resetPassword = () => {
    axios.post('/api/v1/reset-password', form)
        .then(response => {
            router.push({ name: 'home' });
            notify({
                text: response.data.status,
                type: 'info',
                speed: 1000,
                duration: 5000,
            });
        })
        .catch(e => errors.value = e.response.data.errors);
};
</script>
