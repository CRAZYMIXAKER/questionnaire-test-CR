<template>
    <div class="surveys__item">
        <div class="surveys__item-body">
            <div class="surveys__item-wrapper">
                <h5 class="surveys__item-header">
                    <span>{{ survey.title }}</span>
                </h5>
                <div class="surveys__item-body">
                    <div v-if="survey.questions"
                         class="surveys__item-questions questions">
                        <div v-for="question in survey.questions"
                             class="questions__item">
                            <p class="questions__item-text">{{
                                    question.text
                                }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="surveys__item-button">
                <a class="surveys__item-button-link"><span>Show More</span></a>
            </div>
        </div>

        <div class="surveys__item-buttons">
            <router-link
                :to="{name: 'surveys.show', params: {survey_id: survey.id}}"
                class="surveys__item-link btn btn-link btn-link"
            >
                <span>Open</span>
                <i class="bi bi-link-45deg"></i>
            </router-link>

            <button v-if="isUserAdmin" class="btn btn-danger" type="button"
                    @click="$emit('delete-survey', survey.id)">
                <span>Delete</span>
                <i class="bi bi-trash"></i>
            </button>

            <router-link :to="{
                                name: 'admin.surveys.edit',
                                params: {survey_id: survey.id}
                            }"
                         class="btn btn-light"
            >
                <span>Edit</span>
                <i class="bi bi-pencil"></i>
            </router-link>
        </div>
    </div>
</template>

<script>
import { showMoreLess } from '@/scripts/show-more-less.js';
import { computed, onMounted } from 'vue';
import { useStore } from 'vuex';

export default {
    name: 'SurveyItem',
    props: {
        survey: {
            type: Object,
            require: true,
        },
    },
    setup() {
        const store = useStore();

        const user = computed(() => store.getters.user);
        const isUserAdmin = user.value?.roleses_name.some(role => ['admin', 'super-admin'].includes(role));

        onMounted(() =>
            showMoreLess(
                '.surveys__item',
                'questions__item',
                isUserAdmin ? 3 : 2,
                'surveys__item-button',
            ),
        );

        return {
            user,
            isUserAdmin,
        };
    },
};
</script>
