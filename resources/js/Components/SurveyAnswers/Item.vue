<template>
    <div>
        <p>{{ question }}: {{ answer }}</p>
    </div>
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

<style lang="scss" scoped>

</style>
