<template>
    <div>
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
            <div>Add question</div>
            <div>Delete question</div>
            <div>Change question</div>
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
                        <!--                    <input v-model="question.text" type="text">-->
                        <hr>
                    </div>

                    <div v-if="question.type === 'select'">
                        <div>
                            <label>Selects Question:</label>
                            <span>{{ question.text }}</span>
                            <!--                        <input v-model="question.text" type="text">-->
                        </div>
                        <div v-for="nesting in question.nestings">
                            <label>Answer choice:</label>
                            <span>{{ nesting.text }}</span>
                            <!--                        <input v-model="nesting.text" type="text">-->
                        </div>
                        <hr>
                    </div>

                    <div v-if="question.type === 'subquestion'">
                        <div>
                            <label>Question:</label>
                            <span>{{ question.text }}</span>
                            <!--                        <input v-model="question.text" type="text">-->
                        </div>
                        <div v-for="nesting in question.nestings">
                            <label>Subquestion:</label>
                            <span>{{ nesting.text }}</span>
                            <!--                        <input v-model="nesting.text" type="text">-->
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import { useRoute } from 'vue-router';
import { notify } from '@kyvg/vue3-notification';

const route = useRoute();
const survey = reactive([]);
const originalSurveyTitle = ref('');
const isLoading = ref(true);

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
    .then(res => console.log(res))
    .catch(e => console.log(e));
};

const deleteSurveysQuestion = (questionId) => {
    axios.delete(`/api/v1/survey-questions/${route.params.survey_id}/${questionId}`)
        .then(res => {
            getSurvey();
            notify({
                text: res.message,
                type: 'info',
                speed: 1000,
                duration: 5000,
            });
        })
        .catch(e => console.log(e));
};

onMounted(() => getSurvey());
const showUpdateSurveysButton = computed(() => !isLoading.value && survey.values.title !== originalSurveyTitle.value);

</script>
