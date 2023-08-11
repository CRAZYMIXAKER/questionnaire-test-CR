<template>
    <div class="surveys__item">
        <div class="surveys__item-wrapper">
            <h5 class="surveys__item-header">
                <span>{{ survey.title }}</span>
                <router-link
                    :to="{name: 'surveys.show', params: {survey_id: survey.id}}"
                    class="surveys__item-link"
                >
                    Take the survey
                </router-link>
            </h5>
            <div class="surveys__item-body">
                <div v-if="survey.questions" class="surveys__item-questions questions">
                    <div v-for="question in survey.questions" class="questions__item">
                        <p class="questions__item-text">{{ question.text }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="surveys__item-button">
            <a class="surveys__item-button-link"><span>Show More</span></a>
        </div>
    </div>
</template>

<script>
import { showMoreLess } from '@/scripts/show-more-less.js';

export default {
    name: 'SurveyItem',
    props: {
        survey: {
            type: Object,
            require: true,
        },
    },
    mounted() {
        showMoreLess('.surveys__item', 'questions__item', 2, 'surveys__item-button-link');
    },
};
</script>
