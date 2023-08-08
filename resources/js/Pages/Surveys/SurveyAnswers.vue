<template>
    <div>
        <div v-if="survey.questions && survey.questions.length === answers.length">
            <div>
                <h1>Questionnaire - {{ survey.title }}</h1>
                <p>Created at: {{ survey.created_at }}</p>
            </div>
            <div>
                <h2>Questions:</h2>
                <div v-for="(question, key) in survey.questions" :key="question.id">
                    <SurveyAnswersItem
                        v-if="question.type === 'textarea'"
                        :answer="answers[key]"
                        :question="question.text"
                    />

                    <SurveyAnswersSelect
                        v-if="question.type === 'select'"
                        :answer="answers[key]"
                        :question="question.text"
                    />

                    <SurveyAnswersSubquestions
                        v-if="question.type === 'subquestion'"
                        :answers="answers[key]"
                        :question=question.text
                        :subquestions="question.nestings"
                    />
                </div>
            </div>
            <router-link :to="{name: 'survey', survey_id: this.$route.params.survey_id}">
                Re-run the questionnaire
            </router-link>
        </div>
        <div v-else>
            <p>You didn't fill out the questionnaire numbered {{ $route.params.survey_id }}</p>
        </div>
    </div>
</template>

<script>

import SurveyAnswersItem from '../../Components/SurveyAnswers/Item.vue';
import SurveyAnswersSubquestions from '../../Components/SurveyAnswers/Subquestions.vue';
import SurveyAnswersSelect from '../../Components/SurveyAnswers/Select.vue';

export default {
    components: { SurveyAnswersSelect, SurveyAnswersSubquestions, SurveyAnswersItem },
    data() {
        return {
            survey: [],
            answers: [],
        };
    },
    methods: {
        getQuestions() {
            axios.get(`/api/v1/surveys/${this.$route.params.survey_id}`)
                .then(res => {
                    this.survey = res.data.data.survey;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getAnswers() {
            axios.get(`/api/v1/surveys/${this.$route.params.survey_id}/answers`)
                .then(response => {
                    this.answers = response.data.data.answers;
                })
                .catch(error => console.log(error));
        },
    },
    mounted() {
        this.getQuestions();
        this.getAnswers();
    },
};
</script>
