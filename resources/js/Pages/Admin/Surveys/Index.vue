<template>
    <div>
        <h1 class="h3 mb-4 text-gray-800">Admin Index Survey Page</h1>
        <admin-surveys-table
            :surveys='surveys.values'
            @delete-survey="deleteSurvey($event)"
        />
        <pagination-main
            :pagination="pagination.values"
            @update-page="getSurveys($event)"
        />
    </div>
</template>

<script setup>
import AdminSurveysTable from '@/Components/Admin/_table';
import PaginationMain from '@/Components/Pagination/Main';
import { onMounted, reactive } from 'vue';

const surveys = reactive([]);
const pagination = reactive([]);

const getSurveys = (page = 1) => {
    axios.get(`/api/v1/surveys-questions?page=${page}`)
        .then(res => {
            surveys.values = res.data.data.data;
            pagination.values = res.data.data;
        })
        .catch(error => {
            console.log(error);
        });
};

const deleteSurvey = (surveyId) => {
    axios.delete(`/api/v1/surveys/${surveyId}`)
        .then(() => getSurveys())
        .catch(e => console.log(e));
};

onMounted(() => getSurveys());
</script>

<style lang="scss" scoped>
</style>
