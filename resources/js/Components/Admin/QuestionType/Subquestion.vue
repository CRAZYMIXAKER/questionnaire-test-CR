<template>
    <div v-if="question">
        <div>
            <label>Question:</label>
            <span>{{ question.text }}</span>
        </div>
        <div v-for="nesting in question.nestings">
            <label>Subquestion:</label>
            <span>{{ nesting.text }}</span>
        </div>
    </div>
</template>

<script setup>
const {} = defineProps(['question']);
</script>
