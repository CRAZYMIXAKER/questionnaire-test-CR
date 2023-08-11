<template>
    <div v-if="question && answer" class="survey-answers__select">
        <h3 class="survey-answers__select-question">Select: {{ question }}</h3>
        <p class="survey-answers__select-answer">Answer: {{ answer }}</p>
    </div>
</template>

<script>
export default {
    name: 'SurveyAnswersSelect',
    props: {
        question: {
            type: String,
            require: true,
        },
        answer: {
            type: String,
            require: true,
        },
    },
};
</script>
