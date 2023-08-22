<template>
    <div>
        <div v-if="surveys">
            <h1>Questionnaires</h1>
            <survey-list :surveys="surveys"/>
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
                    this.surveys = res.data.data.surveys.data;
                    this.pagination = res.data.data.surveys;
                })
                .catch(error => {
                    console.log(error);
                });
        },
    },
    mounted() {
        this.getSurveys();
    },
};
</script>
