<template>
    <div v-if="question && answer" class="survey-answers__textarea">
        <h3 class="survey-answers__textarea-text">
            <span>{{ question }}:</span>
            {{ answer }}
        </h3>
    </div>
</template>

<script>
export default {
    name: 'SurveyAnswersArea',
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
