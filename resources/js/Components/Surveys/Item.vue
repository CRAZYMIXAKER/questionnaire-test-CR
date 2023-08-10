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
                    <p v-for="question in survey.questions" class="questions__item">
                        {{ question.text }}
                    </p>
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

<style lang="scss" scoped>
.surveys__item {
    background: #fff;
    border-radius: 8px;
    border: 1px gray solid;
    max-height: 180px;
    max-width: calc((100% - 56px) / 4);
    overflow: hidden;
    width: calc((100% - 56px) / 4);

    &-wrapper {
        padding: 10px 20px;
    }

    &-header {
        display: flex;
        flex-wrap: nowrap;
        gap: 6px 12px;
        text-wrap: nowrap;
        justify-content: space-between;
    }

    .questions {
        &__item {
            display: none;

            &--show {
                display: block;
            }
        }
    }

    &-button a {
        align-items: center;
        background: lightgray;
        display: flex;
        justify-content: center;
        padding: 10px 0;
        width: 100%;

        &:hover {
            cursor: pointer;
        }
    }
}
</style>
