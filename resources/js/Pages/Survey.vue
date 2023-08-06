<template>
    <div>
        <div v-show="message" style="position:absolute; top: 10px; padding: 15px;background: #ef4444; color: white">
            {{ message }}
        </div>

        <div v-if="survey.questions">
            <h1>{{ survey.title }}</h1>

            <label>{{ currentQuestion }}</label>
            <div v-for="(question, key) in survey.questions">
                <div v-if="question.type === 'textarea'" v-show="currentQuestionIndex === key" :key="question.id">
                    <textarea v-model="answeredQuestions[key]"/>
                </div>
                <div v-if="question.type === 'select'" v-show="currentQuestionIndex === key" :key="question.id">
                    <select
                        id="country"
                        v-model="answeredQuestions[key]"
                        :value="answeredQuestions[key]"
                        class="form-select"
                        name="country">
                        <option disabled>Choose Answer</option>
                        <option
                            v-for="nesting in question.nestings"
                            :key="nesting.id"
                            :value="nesting.id">
                            {{ nesting.text }}
                        </option>
                    </select>
                </div>
                <div v-if="question.type === 'subquestion'" v-show="currentQuestionIndex === key" :key="question.id">
                    <div v-for="(subquestion, subKey) in question.nestings" :key="subquestion.id">
                        <label>{{ subquestion.text }}</label>
                        <input
                            type="number"
                            @input="updateSubquestionAnswer(key, subKey, $event.target.value)">
                    </div>
                </div>
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

export default {
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
                }).then(res => console.log(res)).catch(error => console.log(error));

                if (this.currentQuestionIndex === this.survey.questions.length - 1) {
                    console.log('finish');
                    axios.post('/api/v1/answers', {
                        survey_id: this.survey.id,
                    });
                } else {
                    console.log('not finish');
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
    computed: {
        // showNext() {
        //     this.showNextQuestion = !!(
        //         this.currentQuestionIndex < this.survey.questions.length &&
        //         this.answeredQuestions[this.currentQuestionIndex + 1]
        //     );
        // },
        // showPrevious() {
        //     this.showPreviousQuestion = this.currentQuestionIndex > 0;
        // },
        // updateCurrentQuestion() {
        //     this.currentQuestion = this.survey.questions[this.currentQuestionIndex].text;
        // },
    },
};
</script>
