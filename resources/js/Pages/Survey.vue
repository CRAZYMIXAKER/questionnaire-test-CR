<template>
    <div>
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
                <button v-show="showPreviousQuestion" @click="this.currentQuestionIndex--">Предыдущий вопрос</button>
                <button v-show="showNextQuestion" @click="this.currentQuestionIndex++">Следующий вопрос</button>
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
                    }).then(() => {
                        this.$router.push('/');
                        this.$notify({
                            text: 'Thank you for answering the questions!',
                            type: 'success',
                            speed: 1000,
                            duration: 5000,
                        });
                    }).catch(error => console.log(error));
                } else {
                    this.currentQuestionIndex++;
                }
            } else {
                if (this.currentQuestionIndex === this.survey.questions.length) {
                    this.$notify({
                        text: 'Please answer the current question to finish questionnaire.',
                        type: 'error',
                        speed: 1000,
                        duration: 5000,
                    });
                } else {
                    this.$notify({
                        text: 'Please answer the current question to move on to the next question.',
                        type: 'error',
                        speed: 1000,
                        duration: 5000,
                    });
                }
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
