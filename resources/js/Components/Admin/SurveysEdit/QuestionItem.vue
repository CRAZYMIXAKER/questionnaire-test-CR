<template>
    <div>
        <hr style="width: 100%;">
        <div style="display: flex; column-gap: 12px;">
            <div style="display: flex; flex-direction: column; row-gap: 10px">
                <button
                    class="btn btn-danger"
                    type="button"
                    @click="$emit('delete-surveys-question', question.id)"
                >
                    <i class="bi bi-trash"></i>
                </button>
                <router-link
                    :to="{
                        name: 'admin.questions.edit',
                        params: {id: question.id}
                    }"
                    class="btn btn-info"
                >
                    <i class="bi bi-pencil"></i>
                </router-link>
            </div>

            <question-textarea
                v-if="question.type === 'textarea'"
                :question="question"
            />

            <question-select
                v-if="question.type === 'select'"
                :question="question"
            />

            <question-subquestion
                v-if="question.type === 'subquestion'"
                :question="question"
            />
        </div>
    </div>
</template>

<script setup>
import QuestionSelect from '@/Components/Admin/QuestionType/Select';
import QuestionTextarea from '@/Components/Admin/QuestionType/Textarea';
import QuestionSubquestion from '@/Components/Admin/QuestionType/Subquestion';

const {} = defineProps(['question']);
</script>
