<template>
    <div v-if="question" style="width: 100%;">
        <label>Surveys Title</label>
        <span>{{ question.text }}</span>
    </div>
</template>

<script setup>
const { } = defineProps(['question'])
</script>
