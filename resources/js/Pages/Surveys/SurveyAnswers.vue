<template>
    <div class="survey-answers">
        <template v-if="survey.questions && survey.questions.length === answers.length">
            <div class="survey-answers__title">
                <h1 class="survey-answers__title-text">Questionnaire - {{ survey.title }}</h1>
                <p class="survey-answers__title-date">
                    Created at: {{ moment(survey.created_at).format('MMMM Do YYYY') }}
                </p>
            </div>
            <div class="survey-answers__wrapper">
                <template v-for="(question, key) in survey.questions" :key="question.id">
                    <survey-answers-textarea
                        v-if="question.type === 'textarea'"
                        :answer="answers[key]"
                        :question="question.text"
                    />

                    <survey-answers-select
                        v-if="question.type === 'select'"
                        :answer="answers[key]"
                        :question="question.text"
                    />

                    <survey-answers-subquestions
                        v-if="question.type === 'subquestion'"
                        :answers="answers[key]"
                        :question=question.text
                        :subquestions="question.nestings"
                    />
                </template>
            </div>
            <router-link
                :to="{name: 'surveys.show', params: {survey_id: this.$route.params.survey_id}}"
                class="survey-answers__link"
            >
                Re-run the questionnaire
            </router-link>
        </template>
        <div v-else>
            <p>You didn't fill out the questionnaire numbered {{ $route.params.survey_id }}</p>
        </div>
    </div>
</template>

<script>

import SurveyAnswersTextarea from '@/Components/SurveyAnswers/Textarea.vue';
import SurveyAnswersSubquestions from '@/Components/SurveyAnswers/Subquestions.vue';
import SurveyAnswersSelect from '@/Components/SurveyAnswers/Select.vue';
import moment from 'moment';

export default {
    computed: {
        moment() {
            return moment;
        },
    },
    components: { SurveyAnswersSelect, SurveyAnswersSubquestions, SurveyAnswersTextarea },
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
