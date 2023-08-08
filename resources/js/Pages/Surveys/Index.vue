<template>
    <div>
        <div v-if="surveys">
            <h1>Questionnaires</h1>
            <SurveyList :surveys="surveys"/>
        </div>
        <div v-else>
            <p>Questionnaires not found.</p>
        </div>
    </div>
</template>

<script>
import SurveyList from '@/Components/Surveys/List.vue';

export default {
    components: { SurveyList },
    data() {
        return {
            surveys: [],
        };
    },
    methods: {
        getSurveys() {
            axios.get(`/api/v1/surveys`)
                .then(res => {
                    this.surveys = res.data.data.surveys;
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
