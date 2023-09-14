<template>
    <div>
        <question-selection-modal
            :modal-status="modalStatus"
            :survey-id="survey.values.id"
            @update-modal-status="modalStatus = $event"
        />
        <h1 class="h3 mb-4 text-gray-800">Admin Edit Survey Page</h1>
        <div>
            <div style="display: flex; column-gap: 12px;">
                <div>
                    <label>Surveys Title</label>
                    <input v-model="survey.values.title" type="text">
                </div>
                <button
                    v-if="showUpdateSurveysButton"
                    class="btn btn-info"
                    @click="updateSurvey"
                >
                    Update
                </button>
            </div>
            <hr>
            <button class="btn btn-info" @click="openQuestionSelectionModal">
                Add question
            </button>
            <div>
                <div
                    v-for="question in survey.values.questions"
                    style="display: flex; column-gap: 12px;"
                >
                    <div
                        style="display: flex; flex-direction: column; row-gap: 10px"
                    >
                        <button
                            class="btn btn-danger"
                            type="button"
                            @click="deleteSurveysQuestion(question.id)"
                        >
                            <i class="bi bi-trash"></i>
                        </button>
                        <router-link
                            :to="{
                                name: 'admin.surveys.edit',
                                params: {survey_id: survey.id}
                            }"
                            class="btn btn-info"
                        >
                            <i class="bi bi-pencil"></i>
                        </router-link>
                    </div>

                    <div v-if="question.type === 'textarea'">
                        <label>Surveys Title</label>
                        <span>{{ question.text }}</span>
                        <hr>
                    </div>

                    <div v-if="question.type === 'select'">
                        <div>
                            <label>Selects Question:</label>
                            <span>{{ question.text }}</span>
                        </div>
                        <div v-for="nesting in question.nestings">
                            <label>Answer choice:</label>
                            <span>{{ nesting.text }}</span>
                        </div>
                        <hr>
                    </div>

                    <div v-if="question.type === 'subquestion'">
                        <div>
                            <label>Question:</label>
                            <span>{{ question.text }}</span>
                        </div>
                        <div v-for="nesting in question.nestings">
                            <label>Subquestion:</label>
                            <span>{{ nesting.text }}</span>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import QuestionSelectionModal from '@/Components/Admin/QuestionSelectionModal';
import { computed, onMounted, reactive, ref, watch } from 'vue';
import { useRoute } from 'vue-router';
import { notify } from '@kyvg/vue3-notification';

const route = useRoute();
const survey = reactive([]);
const originalSurveyTitle = ref('');
const isLoading = ref(true);
const modalStatus = ref(false);

const showUpdateSurveysButton = computed(
    () =>
        !isLoading.value &&
        survey.values.title !== originalSurveyTitle.value,
);

const onModalStatusChange = () => {
    if (!modalStatus.value) {
        getSurvey();
    }
};

const getSurvey = () => {
    axios.get(`/api/v1/surveys/${route.params.survey_id}`)
        .then(res => {
            survey.values = res.data.data;
            originalSurveyTitle.value = survey.values.title;
            isLoading.value = false;
        })
        .catch(e => console.log(e));
};

const updateSurvey = () => {
    axios.put(`/api/v1/surveys/${survey.values.id}`, survey.values)
        .then(res => {
            originalSurveyTitle.value = survey.values.title;
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
    axios.delete(`/api/v1/survey/questions/${survey.values.id}/${questionId}`)
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

const openQuestionSelectionModal = () => {
    modalStatus.value = true;

    if (modalStatus.value) {
        $('#questionSelectionModal').modal('show');
    }
};
</script>
