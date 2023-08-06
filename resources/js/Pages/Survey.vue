<template>
    <div>
        <div v-show="message" style="position:absolute; top: 10px; padding: 15px;background: #ef4444; color: white">
            {{ message }}
        </div>

        <div v-if="survey.questions">
            <h1>{{ survey.title }}</h1>

            <label>{{ currentQuestion }}</label>
            <div v-for="(question, key) in survey.questions">
                <survey-textarea
                    v-if="question.type === 'textarea'"
                    v-show="currentQuestionIndex === key"
                    :key="question.id"
                    :value="answeredQuestions[key]"
                    @update-textarea-answer="answeredQuestions[key] = $event"
                />
                <survey-select
                    v-if="question.type === 'select'"
                    v-show="currentQuestionIndex === key"
                    :key="question.id"
                    :select="question.nestings"
                    :value="answeredQuestions[key]"
                    @update-select-answer="answeredQuestions[key] = $event"
                />
                <survey-subquestions
                    v-if="question.type === 'subquestion'"
                    v-show="currentQuestionIndex === key"
                    :key="question.id"
                    :subquestions="question.nestings"
                    @update-subquestion-answer="updateSubquestionAnswer(key, $event, $event)"
                />
            </div>
            <div>
                <button @click="submitAnswer">
                    {{ currentQuestionIndex === survey.questions.length - 1 ? 'Finish' : 'Submit' }}
                </button>
                <button v-show="showPreviousQuestion" @click="goToPreviousQuestion">Предыдущий вопрос</button>
                <button v-show="showNextQuestion" @click="goToNextQuestion">Следующий вопрос</button>
            </div>
        </div>

    </div>
</template>

<script>

import SurveySubquestions from '../Components/Surveys/Subquestions.vue';
import SurveyTextarea from '../Components/Surveys/Textarea.vue';
import SurveySelect from '../Components/Surveys/Select.vue';

export default {
    components: { SurveySelect, SurveyTextarea, SurveySubquestions },
    data() {
        return {
            message: '',
            survey: [],
            currentQuestion: '',
            currentQuestionIndex: 0,
            answeredQuestions: {},
            showNextQuestion: false,
            showPreviousQuestion: false,
        };
    },
    methods: {
        getQuestions() {
            axios.get(`/api/v1/surveys/${this.$route.params.id}`).then(res => {
                this.survey = res.data;
                this.currentQuestion = this.survey.questions[0].text;
            }).catch(error => {
                console.log(error);
            });
        },
        submitAnswer() {
            if (this.answeredQuestions[this.currentQuestionIndex]) {
                axios.post('/api/v1/answers/temporary', {
                    survey_id: this.survey.id,
                    question_id: this.survey.questions[this.currentQuestionIndex].id,
                    answer: this.answeredQuestions[this.currentQuestionIndex],
                }).catch(error => console.log(error));

                if (this.currentQuestionIndex === this.survey.questions.length - 1) {
                    axios.post('/api/v1/answers', {
                        survey_id: this.survey.id,
                    }).then(response => {
                        this.$router.push('/');
                    }).catch(error => console.log(error));
                } else {
                    this.currentQuestionIndex++;
                    this.message = '';
                }
            } else {
                if (this.currentQuestionIndex === this.survey.questions.length) {
                    this.message = 'Please answer the current question to finish questionnaire.';
                } else {
                    this.message = 'Please answer the current question to move on to the next question.';
                }
            }
        },
        goToNextQuestion() {
            this.currentQuestionIndex++;
            this.message = '';
        },
        goToPreviousQuestion() {
            if (this.currentQuestionIndex > 0) {
                this.currentQuestionIndex--;
                this.message = '';
            } else {
                this.message = 'It\'s first question';
            }
        },
        updateSubquestionAnswer(key, subKey, value) {
            if (!this.answeredQuestions[key]) {
                this.answeredQuestions[key] = {};
            }
            this.answeredQuestions[key][subKey] = value;
        },
        getTemporaryAnswers() {
            axios.get(`/answers/temporary/${this.$route.params.id}`)
                .then(res => console.log(res))
                .catch(error => console.log(error));
        },
    },
    watch: {
        message() {
            setTimeout(() => {
                this.message = '';
            }, 5000);
        },
        currentQuestionIndex() {
            this.showNextQuestion = !!(
                this.currentQuestionIndex < this.survey.questions.length &&
                this.answeredQuestions[this.currentQuestionIndex + 1]
            );
            this.showPreviousQuestion = this.currentQuestionIndex > 0;
            this.currentQuestion = this.survey.questions[this.currentQuestionIndex].text;
        },
    },
    mounted() {
        this.getQuestions();
        this.getTemporaryAnswers();
    },
};
</script>
