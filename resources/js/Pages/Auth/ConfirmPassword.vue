<template>
    <div>
        <div class="mb-4 text-sm text-gray-600">
            This is a secure area of the application. Please confirm your password before continuing.
        </div>

        <div class="form">
            <!-- Password -->
            <div>
                <label for="password">Password</label>

                <input
                    id="password"
                    v-model="form.password"
                    autocomplete="current-password"
                    class="block mt-1 w-full"
                    required
                    type="password"
                />
                <label v-if="errors?.password" class="mt-2">{{ errors.password[0] }}</label>
            </div>
            <div class="flex justify-end mt-4">
                <button @click="confirmPassword">Confirm</button>
            </div>
        </div>

    </div>
</template>

<script setup>
import { reactive, ref } from 'vue';

const form = reactive({
    password: '',
});
const errors = ref([]);

const confirmPassword = () => {
    // it's not working, just preparation for using it in a future
    // axios.post('password.confirm', form)
    //     .then(res => console.log(res))
    //     .catch(e => console.log(e));
};
</script>
