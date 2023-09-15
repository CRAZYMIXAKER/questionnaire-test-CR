<template>
    <h1 class="h3 mb-4 text-gray-800">Admin Edit Question Page</h1>
</template>
<script setup>
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const question = ref([]);

const getQuestion = () => {
    axios.get(`/api/v1/${route.params.survey_id}`)
        .then(res => {
            console.log(res);
        })
        .catch(e => console.log(e));
};

onMounted(() => getQuestion());
</script>
