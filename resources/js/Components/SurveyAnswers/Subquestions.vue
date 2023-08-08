<template>
    <div>
        <h3>Subquestions: <span>{{ question }}</span></h3>
        <div v-for="(subquestion, subKey) in subquestions" :key="subquestion.id">
            <SurveyAnswersItem
                :answer="answers?.[subKey]"
                :question="subquestion.text"
            />
        </div>
    </div>
</template>

<script>
import SurveyAnswersItem from './Item.vue';

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

<style lang="scss" scoped>

</style>
