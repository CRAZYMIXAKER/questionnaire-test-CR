<template>
    <div class="card shadow mb-4">
        <div class="card-header py-3"
             style="display:flex; justify-content: space-between"
        >
            <h6 class="m-0 font-weight-bold text-primary">
                DataTables Example
            </h6>
            <router-link
                :to="{name: 'admin.surveys.create'}"
                class="btn btn-info"
            >
                <span>Create</span>
            </router-link>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table
                    cellspacing="0"
                    class="table table-bordered"
                    width="100%"
                >
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Questions</th>
                        <th>Manage</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="survey in surveys"
                        :key="survey.id"
                        class="table__questions"
                    >
                        <td>{{ survey.title }}</td>
                        <td>
                            <table v-if="survey.questions.length > 0"
                                   style="width: 100%;">

                                <tr>
                                    <td>Title</td>
                                    <td>Type</td>
                                </tr>

                                <template v-for="question in survey.questions">
                                    <tr v-if="question.type === 'textarea'">
                                        <th>{{ question.text }}</th>
                                        <th>{{ question.type }}</th>
                                    </tr>

                                    <template
                                        v-if="question.type === 'select' ||
                                        question.type === 'subquestion'"
                                    >
                                        <tr>
                                            <td>{{ question.text }}</td>
                                            <td>{{ question.type }}</td>
                                        </tr>

                                        <template
                                            v-if="question.nestings.length > 0"
                                        >
                                            <tr v-for="nesting in question.nestings">
                                                <td>{{ nesting.text }}</td>
                                                <td></td>
                                            </tr>
                                        </template>
                                    </template>

                                </template>
                            </table>
                            <div v-else>Not Found</div>
                        </td>
                        <td>
                            <button
                                class="btn btn-danger"
                                style="margin-right: 12px"
                                type="button"
                                @click="$emit('delete-survey', survey.id)"
                            >
                                <span>Delete</span>
                                <i class="bi bi-trash"></i>
                            </button>
                            <router-link
                                :to="{
                                name: 'admin.surveys.edit',
                                params: {survey_id: survey.id}
                            }"
                                class="btn btn-light"
                            >
                                <span>Edit</span>
                                <i class="bi bi-pencil"></i>
                            </router-link>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script setup>
const {} = defineProps(['surveys']);
</script>
