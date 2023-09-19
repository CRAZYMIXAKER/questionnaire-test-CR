<template>
    <div>
        <question-selection-modal
            :modal-status="modalStatus"
            :survey-id="survey.id"
            @update-modal-status="modalStatus = $event"
        />

        <h1 class="h3 mb-4 text-gray-800">Admin Edit Survey Page</h1>
        <div>
            <div style="display: flex; column-gap: 12px;">
                <div>
                    <label>Surveys Title</label>
                    <input v-model="survey.title" type="text">
                </div>
                <button
                    v-if="showUpdateSurveysButton"
                    class="btn btn-info"
                    @click="updateSurvey"
                >
                    Update
                </button>
            </div>
            <hr style="width: 100%;">
            <button class="btn btn-info" @click="showQuestionSelectionModal">
                Add question
            </button>

            <div v-if="survey.questions?.length>0">
                <question-item
                    v-for="question in survey.questions"
                    :question="question"
                    @delete-surveys-question="deleteSurveysQuestion($event)"
                />
            </div>
            <div v-else>no questions</div>
        </div>
    </div>
</template>

<script setup>
import QuestionSelectionModal from '@/Components/Admin/QuestionSelectionModal';
import QuestionItem from '@/Components/Admin/SurveysEdit/QuestionItem';

import { computed, onMounted, ref, watch } from 'vue';
import { useRoute } from 'vue-router';
import { notify } from '@kyvg/vue3-notification';

const route = useRoute();
const survey = ref([]);
const originalSurveyTitle = ref('');
const isLoading = ref(true);
const modalStatus = ref(false);

const showUpdateSurveysButton = computed(
    () =>
        !isLoading.value &&
        survey.value.title !== originalSurveyTitle.value,
);

const onModalStatusChange = () => {
    if (!modalStatus.value) {
        getSurvey();
    }
};

const getSurvey = () => {
    axios.get(`/api/v1/surveys/${route.params.survey_id}`)
        .then(res => {
            survey.value = res.data.data;
            originalSurveyTitle.value = survey.value.title;
            isLoading.value = false;
        })
        .catch(e => console.log(e));
};

const updateSurvey = () => {
    axios.put(`/api/v1/surveys/${survey.value.id}`, survey.value)
        .then(res => {
            originalSurveyTitle.value = survey.value.title;
            notify({
                text: res.data.message,
                type: 'info',
                speed: 1000,
                duration: 5000,
            });
        })
        .catch(e => console.log(e));
};

const deleteSurveysQuestion = (questionId) => {
    axios.delete(`/api/v1/surveys/${survey.value.id}/questions/${questionId}`)
        .then(res => {
            getSurvey();
            notify({
                text: res.data.message,
                type: 'info',
                speed: 1000,
                duration: 5000,
            });
        })
        .catch(e => console.log(e));
};

onMounted(() => getSurvey());

watch(() => modalStatus.value, onModalStatusChange);

const showQuestionSelectionModal = () => {
    modalStatus.value = true;

    if (modalStatus.value) {
        $('#modalWindow').modal('show');
    }
};
</script>
