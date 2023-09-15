<template>
    <div
        id="questionSelectionModal"
        aria-hidden="true"
        aria-labelledby="questionSelectionModalLabel"
        class="modal fade"
        role="dialog"
        tabindex="-1"
        @click.stop="closeModal"
    >
        <div class="modal-dialog" role="document" @click.stop>
            <div class="modal-content" style="background: mediumaquamarine;">
                <div class="modal-header">
                    <h5
                        id="questionSelectionModalLabel"
                        class="modal-title"
                    >
                        Check question
                    </h5>
                    <button
                        aria-label="Close"
                        class="close"
                        data-dismiss="modal"
                        type="button"
                        @click="closeModal"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul v-if="questions.length>0">
                        <li
                            v-for="question in questions"
                            :key="question.id"
                        >
                            <input
                                v-model="checkedQuestions"
                                :value="question.id"
                                type="checkbox"
                            >
                            {{ question.text }}
                        </li>
                    </ul>
                    <div v-else>No Questions</div>
                </div>

                <div v-if="pagination.length>0" class="pagination">
                    <pagination-main
                        :pagination="pagination"
                        @update-page="getNotSurveyQuestions($event)"
                    />
                </div>

                <div class="modal-footer">
                    <button
                        v-if="checkedQuestions.length > 0"
                        class="btn btn-primary"
                        type="button"
                        @click="addSurveyQuestions"
                    >
                        Add question/-s
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import PaginationMain from '@/Components/Pagination/Main.vue';
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
    $('#questionSelectionModal').modal('hide');
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
