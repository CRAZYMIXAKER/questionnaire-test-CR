<template>
    <div class="survey-questions">
        <div v-if="survey.questions" class="survey-questions__wrapper">
            <h1 class="survey-questions__title">{{ survey.title }}</h1>
            <label class="survey-questions__question">{{ currentQuestion }}</label>

            <template v-for="(question, key) in survey.questions">
                <survey-textarea
                    v-if="question.type === 'textarea'"
                    v-show="currentQuestionIndex === key"
                    :key="question.id"
                    :value="answeredQuestions[key] ?? ''"
                    @update-textarea-answer="answeredQuestions[key] = $event"
                />
                <survey-select
                    v-if="question.type === 'select'"
                    v-show="currentQuestionIndex === key"
                    :key="question.id"
                    :select="question.nestings"
                    :value="answeredQuestions[key] ?? ''"
                    @update-select-answer="answeredQuestions[key] = $event"
                />
                <survey-subquestions
                    v-if="question.type === 'subquestion'"
                    v-show="currentQuestionIndex === key"
                    :key="question.id"
                    :subquestions="question.nestings"
                    :values="answeredQuestions[key] ?? ''"
                    @update-subquestion-answer="updateSubquestionAnswer(key, $event.key, $event.value)"
                />
            </template>
            <div class="survey-questions__buttons">
                <button class="survey-questions__buttons-item" @click="submitAnswer">
                    {{ currentQuestionIndex === survey.questions.length - 1 ? 'Finish' : 'Submit' }}
                </button>
                <button
                    v-if="showPreviousQuestion"
                    class="survey-questions__buttons-item"
                    @click="this.currentQuestionIndex--"
                >
                    <span>Previous Question</span>
                </button>
                <button
                    v-if="showNextQuestion"
                    class="survey-questions__buttons-item"
                    @click="this.currentQuestionIndex++"
                >
                    <span>Next question</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import SurveySubquestions from '@/Components/Surveys/Subquestions.vue';
import SurveyTextarea from '@/Components/Surveys/Textarea.vue';
import SurveySelect from '@/Components/Surveys/Select.vue';

export default {
    components: { SurveySelect, SurveyTextarea, SurveySubquestions },
    data() {
        return {
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
            axios.get(`/api/v1/surveys/${this.$route.params.survey_id}`)
                .then(response => {
                    this.survey = response.data.data;
                    this.currentQuestion = this.survey.questions[0].text;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        submitAnswer() {
            let currentAnswer = this.answeredQuestions[this.currentQuestionIndex];
            let currentQuestion = this.survey.questions[this.currentQuestionIndex];
            let checkAnswer = this.checkAnswer(currentAnswer, currentQuestion);

            if (!checkAnswer) {
                return false;
            }

            axios.post('/api/v1/answers/temporary', {
                survey_id: this.survey.id,
                question_id: currentQuestion.id,
                answer: currentAnswer,
            })
                .then(() => {
                    if (this.currentQuestionIndex === this.survey.questions.length - 1) {
                        axios.post('/api/v1/answers', { survey_id: this.survey.id })
                            .then(() => {
                                this.$router.push(`/surveys/${this.$route.params.survey_id}/answers`);
                                this.$notify({
                                    text: 'Thank you for answering the questions!',
                                    type: 'success',
                                    speed: 1000,
                                    duration: 5000,
                                });
                            })
                            .catch(error => console.log(error));
                    } else {
                        this.currentQuestionIndex++;
                    }
                })
                .catch(error => console.log(error));
        },
        checkAnswer(currentAnswer, currentQuestion) {
            let checkLastQuestionStep = this.currentQuestionIndex === this.survey.questions.length - 1;

            if (!currentAnswer && checkLastQuestionStep) {
                this.$notify({
                    text: 'Please answer the current question to finish questionnaire.',
                    type: 'error',
                    speed: 1000,
                    duration: 5000,
                });
                return false;
            }

            if (!currentAnswer && !checkLastQuestionStep) {
                this.$notify({
                    text: 'Please answer the current question to move on to the next question.',
                    type: 'error',
                    speed: 1000,
                    duration: 5000,
                });
                return false;
            }

            if (currentQuestion.type === 'subquestion') {
                let currentSubquestionsAnswers = Object.values(currentAnswer);
                let countCurrentSubquestionsQuestions = Object.keys(currentQuestion.nestings).length;

                if (countCurrentSubquestionsQuestions !== currentSubquestionsAnswers.length) {
                    this.$notify({
                        text: 'Please answer all the sub-questions of this question.',
                        type: 'error',
                        speed: 1000,
                        duration: 5000,
                    });
                    return false;
                }

                if (!currentSubquestionsAnswers.every(value => !!value)) {
                    this.$notify({
                        text: 'Please only enter numbers between 1 and 5.',
                        type: 'error',
                        speed: 1000,
                        duration: 5000,
                    });
                    return false;
                }
            }

            return true;
        },
        updateSubquestionAnswer(key, subKey, value) {
            if (!this.answeredQuestions[key]) {
                this.answeredQuestions[key] = {};
            }
            this.answeredQuestions[key][subKey] = value;
        },
        getAnswers() {
            axios.get(`/api/v1/answers/${this.$route.params.survey_id}`)
                .then(response => {
                    this.answeredQuestions = response.data.data;
                })
                .catch(error => console.log(error));
        },
        shouldShowNextQuestion() {
            return !!(
                this.currentQuestionIndex < this.survey.questions.length &&
                this.answeredQuestions[this.currentQuestionIndex + 1]
            );
        },
    },
    mounted() {
        this.getQuestions();
        this.getAnswers();
    },
    computed: {
        showButtonNext() {
            this.showNextQuestion = this.shouldShowNextQuestion();
        },
    },
    watch: {
        currentQuestionIndex() {
            this.showNextQuestion = this.shouldShowNextQuestion();
            this.showPreviousQuestion = this.currentQuestionIndex > 0;
            this.currentQuestion = this.survey.questions[this.currentQuestionIndex].text;
        },
    },
};
</script>
