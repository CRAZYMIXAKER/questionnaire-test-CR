<template>
    <modal-window :close-function="closeModal">
        <template #title>Check question</template>
        <template #body>
            <div>
                <ul v-if="questions.length>0">
                    <li
                        v-for="question in questions"
                        :key="question.id"
                        class="form-check"
                    >
                        <input
                            v-model="checkedQuestions"
                            :value="question.id"
                            class="form-check-input"
                            type="checkbox"
                        >
                        <label class="form-check-label">
                            {{ question.text }}
                        </label>
                    </li>
                </ul>
                <div v-else>No Questions</div>

                <div v-if="pagination.length>0" class="pagination">
                    <pagination-main
                        :pagination="pagination"
                        @update-page="getNotSurveyQuestions($event)"
                    />
                </div>
            </div>
        </template>
        <template #footer>
            <button
                v-if="checkedQuestions.length > 0"
                class="btn btn-primary"
                type="button"
                @click="addSurveyQuestions"
            >
                Add question/-s
            </button>
        </template>
    </modal-window>
</template>

<script setup>
import ModalWindow from '@/Components/ModalWindow/Default';
import PaginationMain from '@/Components/Pagination/Main';
import { notify } from '@kyvg/vue3-notification';
import { defineEmits, ref, watch } from 'vue';

const emit = defineEmits();

const checkedQuestions = ref([]);
const questions = ref([]);
const pagination = ref([]);

const props = defineProps({
    surveyId: { type: Number },
    modalStatus: { type: Boolean },
});

const closeModal = () => {
    emit('update-modal-status', false);
    checkedQuestions.value = [];
};

const getNotSurveyQuestions = (page = 1) => {
    axios.get(`/api/v1/not-survey-questions/${props.surveyId}?page=${page}`)
        .then(res => {
            questions.value = res.data.data.data;
            pagination.value = res.data.data;
        })
        .catch(e => console.log(e));
};

const onModalStatusChange = () => {
    if (props.modalStatus) {
        getNotSurveyQuestions();
    }
};

watch(() => props.modalStatus, onModalStatusChange);

const addSurveyQuestions = () => {
    axios.post('/api/v1/survey/questions/create', {
        survey_id: props.surveyId,
        question_ids: checkedQuestions.value,
    })
        .then(res => {
            closeModal();
            notify({
                text: res.data.message,
                type: 'info',
                speed: 1000,
                duration: 5000,
            });
        })
        .catch(e => {
            closeModal();
            notify({
                text: e,
                type: 'error',
                speed: 1000,
                duration: 5000,
            });
        });
};
</script>
