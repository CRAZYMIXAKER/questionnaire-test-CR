<template>
    <div class="survey-question-select">
        <h3>Select: <span>{{ question }}</span></h3>
        <p>Answer: {{ answer }}</p>
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

<style lang="scss" scoped>

</style>
