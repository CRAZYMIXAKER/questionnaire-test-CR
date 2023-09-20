<template>
    <div>
        <div v-if="surveys">
            <h1>Questionnaires</h1>
            <survey-list
                :surveys="surveys"
                @delete-survey="deleteSurvey($event)"
            />
            <pagination-main
                :pagination="pagination"
                @update-page="getSurveys($event)"
            />
        </div>
        <div v-else>
            <p>Questionnaires not found.</p>
        </div>
    </div>
</template>

<script setup>
import SurveyList from '@/Components/Surveys/List.vue';
import PaginationMain from '@/Components/Pagination/Main.vue';
import { onMounted, ref } from 'vue';

const surveys = ref([]);
const pagination = ref([]);

const getSurveys = (page = 1) => {
    axios.get(`/api/v1/surveys?page=${page}`)
        .then(res => {
            surveys.value = res.data.data.data;
            pagination.value = res.data.data;
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
