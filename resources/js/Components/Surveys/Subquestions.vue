<template>
    <div v-if="subquestions" class="survey-questions__subquestions">
        <div
            v-for="(subquestion, key) in subquestions"
            :key="subquestion.id"
            class="survey-questions__subquestions-item subquestion"
        >
            <label class="subquestion__title">{{ subquestion.text }}</label>
            <input
                :max="5"
                :min="1"
                :step="1"
                :value="values[key]"
                class="subquestion__input"
                type="number"
                @input="updateSubquestionAnswer(key, $event.target.value)"
            >
        </div>
    </div>
</template>

<script>
export default {
    name: 'SurveySubquestions',
    props: {
        values: {
            type: [Object, String],
            default: '',
        },
        subquestions: {
            type: Object,
            required: true,
        },
    },
    methods: {
        updateSubquestionAnswer(key, value) {
            if (/^[1-5]$/.test(value)) {
                this.$emit('update-subquestion-answer', { key, value });
            } else {
                event.target.value = '';
                this.$emit('update-subquestion-answer', { key, value: '' });
                this.$notify({
                    text: 'Please only enter numbers between 1 and 5.',
                    type: 'error',
                    speed: 1000,
                    duration: 5000,
                });
            }
        },
    },
};
</script>
