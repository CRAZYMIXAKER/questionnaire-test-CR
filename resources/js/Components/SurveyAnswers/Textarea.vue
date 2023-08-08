<template>
    <div class="survey-question-textarea">
        <h3><span>{{ question }}</span>: {{ answer }}</h3>
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
