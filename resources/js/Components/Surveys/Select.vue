<template>
    <div v-if="select" class="survey-questions__select">
        <select
            :value="value"
            @change="$emit('update-select-answer', $event.target.value)"
        >
            <option :value="value ? '' : value" disabled>Choose Answer</option>
            <option
                v-for="option in select"
                :key="option.id"
                :value="option.id"
            >
                {{ option.text }}
            </option>
        </select>
    </div>
</template>

<script>
export default {
    name: 'SurveySelect',
    props: {
        select: {
            type: Object,
            required: true,
        },
        value: {
            type: [String, Number],
            required: true,
        },
    },
};
</script>
