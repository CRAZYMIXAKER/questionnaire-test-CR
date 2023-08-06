<template>
    <div>
        <div v-for="(subquestion, subKey) in subquestions" :key="subquestion.id">
            <label>{{ subquestion.text }}</label>
            <input type="number" @input="updateSubquestionAnswer(subKey, $event.target.value)">
        </div>
    </div>
</template>

<script>
export default {
    name: 'SurveySubquestions',
    props: {
        subquestions: {
            type: Object,
            required: true,
        },
    },
    methods: {
        updateSubquestionAnswer(subKey, value) {
            this.$emit('update-subquestion-answer', subKey, value);
        },
    },
};
</script>
