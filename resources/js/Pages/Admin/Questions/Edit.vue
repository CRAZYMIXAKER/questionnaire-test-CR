<template>
    <div>
        <modal-window>
            <template #title>
                Are you sure you want to change the question type?
                If yes, some data will be deleted/updated.
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
            <h1 class="h3 text-gray-800">Admin Edit Question Page</h1>
            <div>
                <router-link
                    :to="{name: 'admin.questions.index'}"
                    class="btn btn-link"
                >
                    Questions list
                </router-link>
                <button
                    class="btn btn-info"
                    @click="updateQuestion(question.id, question.text)"
                >
                    Update
                </button>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; row-gap: 20px">

            <div style="display: flex; flex-direction: column;">
                <label>Type of Question</label>
                <select
                    v-model="questionType"
                    @change="changeQuestionType"
                >
                    <option disabled>Choose type of question</option>
                    <option :value="'textarea'">Textarea</option>
                    <option :value="'select'">Select</option>
                    <option :value="'subquestion'">Subquestion</option>
                </select>
            </div>

            <div style="display: flex; flex-direction: column;">
                <label>Title</label>
                <input v-model="question.text" type="text">
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
                        v-for="nestingQuestion in question.nestings"
                        :key="nestingQuestion.id"
                        style="display: flex; column-gap: 5px"
                    >
                        <button
                            class="btn btn-danger"
                            type="button"
                            @click="deleteQuestion(nestingQuestion.id)"
                        >
                            <i class="bi bi-trash"></i>
                        </button>
                        <input
                            v-model="nestingQuestion.text"
                            type="text"
                        >
                        <button
                            class="btn btn-info"
                            type="button"
                            @click="updateQuestion(
                                nestingQuestion.id,
                                nestingQuestion.text
                            )"
                        >
                            <i class="bi bi-pencil"></i>
                        </button>
                    </div>
                </div>
                <div style="display: flex; column-gap: 5px">
                    <button
                        class="btn btn-success"
                        type="button"
                        @click="addNestingQuestion(question.id)"
                    >
                        <i class="bi bi-plus"></i>
                    </button>
                    <input v-model="newNestingQuestion" type="text">
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import ModalWindow from '@/Components/ModalWindow/Default';
import router from '@/router/router';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import { notify } from '@kyvg/vue3-notification';

const route = useRoute();
const question = ref([]);
const newNestingQuestion = ref('');
const questionType = ref('');

const getQuestion = () => {
    axios.get(`/api/v1/questions/${route.params.id}`)
        .then(res => {
            question.value = res.data.data;
            questionType.value = question.value.type;
        })
        .catch(e => router.push({ name: 'not.found' }));
};

const addNestingQuestion = (questionId) => {
    axios.post('/api/v1/questions/nesting', {
        text: newNestingQuestion.value,
        type: question.value.type,
        parent_id: question.value.id,
    })
        .then(res => {
            newNestingQuestion.value = '';
            getQuestion();
            notify({
                text: res.data.message,
                type: 'success',
                speed: 1000,
                duration: 5000,
            });
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
    showModalWindow();
};

const deleteQuestion = (questionId) => {
    axios.delete(`/api/v1/questions/${questionId}`)
        .then(res => {
            getQuestion();
            notify({
                text: res.data.message,
                type: 'info',
                speed: 1000,
                duration: 5000,
            });
        })
        .catch(e => console.log(e));
};

const updateQuestion = (id, text) => {
    axios.patch(`/api/v1/questions/${id}`, { text: text })
        .then(res => {
            getQuestion();
            notify({
                text: res.data.message,
                type: 'info',
                speed: 1000,
                duration: 5000,
            });
        })
        .catch(e => console.log(e));
};

const updateQuestionType = () => {
    axios.patch(`/api/v1/questions/${question.value.id}/type`, {
        id: question.value.id,
        type: question.value.type,
    })
        .then(res => {
            getQuestion();
            notify({
                text: res.data.message,
                type: 'info',
                speed: 1000,
                duration: 5000,
            });
        })
        .catch(e => console.log(e));
};

onMounted(() => getQuestion());

// logic for modal window
const showModalWindow = () => {
    $('#modalWindow').modal('show');
};

const hideModalWindow = () => {
    $('#modalWindow').modal('hide');
};

const confirmChanges = () => {
    question.value.type = questionType.value;
    updateQuestionType();
    hideModalWindow();
};

const cancelChanges = () => {
    questionType.value = question.value.type;
    hideModalWindow();
};
</script>
