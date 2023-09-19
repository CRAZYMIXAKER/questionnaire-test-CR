<template>
    <div
        id="modalWindow"
        aria-hidden="true"
        class="modal fade"
        role="dialog"
        tabindex="-1"
        @click.stop="closeModal"
    >
        <div class="modal-dialog" role="document" @click.stop>
            <div class="modal-content" style="background: white;">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <slot v-if="$slots.title" name="title"/>
                    </h5>
                    <button
                        aria-label="Close"
                        class="close"
                        data-dismiss="modal"
                        type="button"
                        @click="closeModal"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div v-if="$slots.body" class="modal-body">
                    <slot name="body"/>
                </div>

                <div v-if="$slots.footer" class="modal-footer">
                    <slot name="footer"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps(['closeFunction']);
const closeModal = () => {
    $('#modalWindow').modal('hide');

    if (props.closeFunction) {
        props.closeFunction();
    }
};
</script>
