<template>
    <div>
        <modal-window>
            <template #title>
                Are you sure you want to change the question type?
                If yes, some data will be deleted.
            </template>
            <template #body>
                <button class="btn btn-success" @click="confirmChanges">
                    Yes
                </button>
                <button class="btn" @click="cancelChanges">No</button>
            </template>
        </modal-window>

        <div
            class="mb-4"
            style="
                display:flex;
                justify-content: space-between;
                align-items: center;
            "
        >
            <h1 class="h3 text-gray-800">Admin Create Question Page</h1>
            <div>
                <router-link
                    :to="{name: 'admin.questions.index'}"
                    class="btn btn-link"
                >
                    Questions list
                </router-link>
                <button
                    class="btn btn-info"
                    @click="createQuestion"
                >
                    Create
                </button>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; row-gap: 20px">

            <div style="display: flex; flex-direction: column;">
                <label>Type of Question</label>
                <select
                    v-model="questionType"
                    class="custom-select"
                    @change="changeQuestionType"
                >
                    <option :value="''" disabled>
                        Choose type of question
                    </option>
                    <option :value="'textarea'">Textarea</option>
                    <option :value="'select'">Select</option>
                    <option :value="'subquestion'">Subquestion</option>
                </select>
            </div>

            <div style="display: flex; flex-direction: column;">
                <label>Text</label>
                <input
                    v-model="question.text"
                    class="form-control"
                    type="text"
                >
            </div>

            <div
                v-if="
                    question.type === 'select' ||
                    question.type === 'subquestion'
                "
                style="display: flex; flex-direction: column; row-gap: 6px"
            >
                <label>Nesting question/-s</label>
                <div
                    v-if="question.nestings?.length > 0"
                    style="display: flex; flex-direction: column; row-gap: 6px"
                >

                    <div
                        v-for="(nestingQuestion, key) in question.nestings"
                        style="display: flex; column-gap: 5px"
                    >
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <button
                                    class="btn btn-danger"
                                    type="button"
                                    @click="deleteQuestion(key)"
                                >
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            <input
                                v-model="nestingQuestion.text"
                                class="form-control"
                                placeholder="Enter question"
                                type="text"
                            >
                        </div>
                    </div>
                </div>

                <!--add nesting question-->
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <button
                            class="btn btn-success"
                            type="button"
                            @click="addNestingQuestion()"
                        >
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                    <input
                        v-model="newNestingQuestion"
                        class="form-control"
                        placeholder="Enter question"
                        type="text"
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import ModalWindow from '@/Components/ModalWindow/Default';
import router from '@/router/index';

import { ref } from 'vue';
import { useRoute } from 'vue-router';
import { notify } from '@kyvg/vue3-notification';

const route = useRoute();
const question = ref({
    text: '',
    type: '',
    nestings: [],
});
const questionType = ref('');
const newNestingQuestion = ref('');

const createQuestion = () => {
    axios.post('/api/v1/questions', question.value)
        .then(res => {
            notify({
                text: res.data.message,
                type: 'success',
                speed: 1000,
                duration: 5000,
            });
            router.push({ name: 'admin.questions.index' });
        })
        .catch(e => {
            notify({
                text: e.response.data.message,
                type: 'error',
                speed: 1000,
                duration: 5000,
            });
        });
};

const changeQuestionType = () => {
    if (question.value.type === '') {
        confirmChanges();

        return;
    }

    showModalWindow();
};

const updateQuestionType = () => {
    question.value.type = questionType.value;
    question.value.nestings = [];
};

const addNestingQuestion = () => {
    if (newNestingQuestion.value === '') {
        notify({
            text: 'The text field is required.',
            type: 'error',
            speed: 1000,
            duration: 5000,
        });
        return;
    }

    question.value.nestings.push({
        text: newNestingQuestion.value,
    });
    newNestingQuestion.value = '';
};

const deleteQuestion = (questionKey) => {
    question.value.nestings.splice(questionKey, 1);
};

// logic for modal window
const showModalWindow = () => {
    $('#modalWindow').modal('show');
};

const hideModalWindow = () => {
    $('#modalWindow').modal('hide');
};

const confirmChanges = () => {
    updateQuestionType();
    hideModalWindow();
};

const cancelChanges = () => {
    questionType.value = question.value.type;
    hideModalWindow();
};
</script>
