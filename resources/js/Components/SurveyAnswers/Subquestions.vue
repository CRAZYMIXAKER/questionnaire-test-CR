<template>
    <div v-if="subquestions && answers && question" class="survey-answers__subquestions">
        <h3 class="survey-answers__subquestions-question">
            Subquestions: <span>{{ question }}</span>
        </h3>

        <SurveyAnswersItem
            v-for="(subquestion, subKey) in subquestions"
            :key="subquestion.id"
            :answer="answers?.[subKey]"
            :question="subquestion.text"
            class="survey-answers__subquestions-item"
        />
    </div>
</template>

<script>
import SurveyAnswersItem from '@/Components/SurveyAnswers/Item.vue';

export default {
    name: 'SurveyAnswersSubquestions',
    components: { SurveyAnswersItem },
    props: {
        question: {
            type: String,
            require: true,
        },
        answers: {
            type: Array,
            require: true,
        },
        subquestions: {
            type: Array,
            require: true,
        },
    },
};
</script>
