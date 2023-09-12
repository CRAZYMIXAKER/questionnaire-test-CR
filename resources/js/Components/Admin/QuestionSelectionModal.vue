<template>
    <div
        id="questionSelectionModal"
        aria-hidden="true"
        aria-labelledby="questionSelectionModalLabel"
        class="modal fade"
        role="dialog"
        tabindex="-1"
    >
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background: mediumaquamarine;">
                <div class="modal-header">
                    <h5 id="questionSelectionModalLabel" class="modal-title">
                        Выберите вопросы для добавления</h5>
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
                    <ul>
                        <li v-for="question in questions" :key="question.id">
                            <input v-model="selectedQuestions"
                                   :value="question.id"
                                   type="checkbox"> {{ question.text }}
                        </li>
                    </ul>
                </div>
                <div class="pagination">
                    <pagination-main :pagination="pagination"/>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal"
                            type="button" @click="closeModal">Закрыть
                    </button>
                    <button class="btn btn-primary" type="button"
                            @click="addSurveyQuestions">Добавить вопросы
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, defineEmits, reactive, watch } from 'vue';
import PaginationMain from '@/Components/Pagination/Main.vue';

const emit = defineEmits();

const checkedQuestions = reactive([]);
const questions = reactive([]);
const pagination = reactive([]);
const { surveyId, modalStatus } = defineProps(['surveyId', 'modalStatus']);

const closeModal = () => {
    console.log(modalStatus);
    emit('updateModalStatus', false);
    $('#questionSelectionModal').modal('hide');
    questions.values = [];
    console.log(modalStatus);
};

const getNotSurveyQuestions = () => {
    axios.get(`/api/v1/not-survey-questions/${surveyId}`)
        .then(res => {
            questions.values = res.data.data.data;
            pagination.values = res.data.data;
        })
        .catch(e => console.log(e));
};

// watch(modalStatus, (newValue) => {
//     console.log('aaaaa');
//
//     if (newValue) {
//         console.log('aaaaabbbbbb');
//         getNotSurveyQuestions();
//     }
// });

watch(() => modalStatus, (newModalStatus, oldModalStatus) => {
    console.log('modalStatus изменился:', newModalStatus);

    if (newModalStatus) {
    }
});

const addSurveyQuestions = () => {};
</script>
