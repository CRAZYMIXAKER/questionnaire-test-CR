<template>
    <div v-if="surveys" class="surveys">
        <survey-item v-for="survey in surveys" :key="survey.id" :survey="survey"/>
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
            require: true,
        },
    },
};
</script>
