<template>
    <div>
        <div v-if="surveys">
            <h1>Questionnaires</h1>
            <survey-list :surveys="surveys" @delete-survey="deleteSurvey($event)"/>
            <pagination-main :pagination="pagination" @update-page="getSurveys($event)"/>
        </div>
        <div v-else>
            <p>Questionnaires not found.</p>
        </div>
    </div>
</template>

<script>
import SurveyList from '@/Components/Surveys/List.vue';
import PaginationMain from '@/Components/Pagination/Main.vue';

export default {
    components: { PaginationMain, SurveyList },
    data() {
        return {
            surveys: [],
            pagination: [],
        };
    },
    methods: {
        getSurveys(page = 1) {
            axios.get(`/api/v1/surveys?page=${page}`)
                .then(res => {
                    this.surveys = res.data.data.data;
                    this.pagination = res.data.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        deleteSurvey(surveyId) {
            axios.delete(`/api/v1/surveys/${surveyId}`)
                .then(() => this.getSurveys())
                .catch(e => console.log(e));
        },
    },
    mounted() {
        this.getSurveys();
    },
};
</script>
