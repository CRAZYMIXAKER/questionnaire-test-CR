<template>
    <div v-for="survey in surveys">
        <SurveyItem :key="survey.id" :survey="survey"/>
    </div>
</template>

<script>
import SurveyItem from '@/Components/Surveys/Item.vue';

export default {
    name: 'SurveyList',
    components: { SurveyItem },
    props: {
        surveys: {
            type: Object,
            require: true
        },
    },
};
</script>
