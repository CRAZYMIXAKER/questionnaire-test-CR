<template>
    <div v-if="question" style="width: 100%;">
        <div>
            <label>Selects Question:</label>
            <span>{{ question.text }}</span>
        </div>
        <div v-for="nesting in question.nestings">
            <label>Answer choice:</label>
            <span>{{ nesting.text }}</span>
        </div>
    </div>
</template>

<script setup>
const {} = defineProps(['question']);
</script>
