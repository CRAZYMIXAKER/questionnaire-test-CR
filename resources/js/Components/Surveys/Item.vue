<template>
    <div>
        <label>{{ survey.title }}</label>
        <router-link :to="{name: 'surveys.show', params: {survey_id: survey.id}}">Take the survey</router-link>
    </div>
</template>

<script>
export default {
    name: 'SurveyItem',
    props: {
        survey: {
            type: Object,
            require: true,
        },
    },
};
</script>
