<template>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title mb-3">Добавить заметку</h5>

            <div
                v-if="successMessage"
                class="toast show align-items-center text-bg-success border-0"
                role="alert"
                aria-live="assertive"
                aria-atomic="true"
            >
                <div class="d-flex">
                    <div class="toast-body">
                        {{ successMessage }}
                    </div>
                    <button
                        type="button"
                        class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast"
                        @click="successMessage = ''"
                    ></button>
                </div>
            </div>

            <form @submit.prevent="submitForm" novalidate>
                <div class="mb-3">
                    <label for="noteTitle" class="form-label">Заголовок</label>
                    <input
                        id="noteTitle"
                        type="text"
                        class="form-control"
                        :class="{'is-invalid': titleTouched && !isTitleValid}"
                        v-model="title"
                        @blur="titleTouched = true"
                        required
                    />
                    <div class="invalid-feedback">
                        Заголовок обязателен (минимум 3 символа).
                    </div>
                </div>

                <div class="mb-3">
                    <label for="noteContent" class="form-label">Содержимое</label>
                    <textarea
                        id="noteContent"
                        class="form-control"
                        rows="4"
                        :class="{'is-invalid': descriptionTouched && !isDescriptionValid}"
                        v-model="description"
                        @blur="descriptionTouched = true"
                        required
                    ></textarea>
                    <div class="invalid-feedback">
                        Содержимое обязательно (минимум 5 символов).
                    </div>
                </div>

                <button
                    type="submit"
                    class="btn btn-primary"
                    :disabled="loading"
                >
                    {{ loading ? 'Добавление…' : 'Добавить' }}
                </button>
            </form>

            <div v-if="error" class="alert alert-danger mt-3">
                {{ error }}
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed, watch } from 'vue';
import { useNotesStore } from '../stores/notesStore';

const store = useNotesStore();

const title = ref('');
const description = ref('');
const titleTouched = ref(false);
const descriptionTouched = ref(false);

const loading = ref(false);
const error = ref<string | null>(null);
const successMessage = ref<string | null>(null);

const isTitleValid = computed(() => title.value.trim().length >= 3);
const isDescriptionValid = computed(() => description.value.trim().length >= 5);
const isFormValid = computed(() => isTitleValid.value && isDescriptionValid.value);

async function submitForm() {
    if (!isFormValid.value) {
        titleTouched.value = true;
        descriptionTouched.value = true;
        return;
    }

    loading.value = true;
    error.value = null;

    try {
        await store.addNote({
            title: title.value,
            description: description.value,
        });

        successMessage.value = 'Заметка успешно добавлена!';

        title.value = '';
        description.value = '';
        titleTouched.value = false;
        descriptionTouched.value = false;

        setTimeout(() => (successMessage.value = null), 3000);
    } catch (e: unknown) {
        error.value = e instanceof Error ? e.message : 'Не удалось добавить заметку';
    } finally {
        loading.value = false;
    }
}

watch(successMessage, (newVal) => {
    if (newVal) {
        setTimeout(() => (successMessage.value = null), 3000);
    }
});
</script>

<style scoped>
.toast {
    position: relative;
    top: 0;
    right: 0;
    z-index: 1055;
    min-width: 250px;
    margin-bottom: 1rem;
}
</style>