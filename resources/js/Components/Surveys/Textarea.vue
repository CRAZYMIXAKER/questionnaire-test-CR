<template>
    <div class="textarea">
        <div class="textarea__body">
            <textarea
                :value="value"
                class="textarea"
                @input="$emit('update-textarea-answer', $event.target.value)"
            />
        </div>
    </div>
</template>

<script>
export default {
    name: 'SurveyTextarea',
    props: {
        value: {
            type: String,
            default: '',
        },
        modelValue: {
            type: String,
        },
    },
};
</script>
