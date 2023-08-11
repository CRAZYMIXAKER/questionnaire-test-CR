<template>
    <p v-if="question && answer">{{ question }}: <span>{{ answer }}</span></p>
</template>

<script>
export default {
    name: 'SurveyAnswersItem',
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
