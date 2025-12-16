<template>
    <div
        class="modal fade"
        :class="{ show: visible }"
        tabindex="-1"
        :style="{ display: visible ? 'block' : 'none' }"
        :aria-hidden="!visible"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Редактировать заметку</h5>
                    <button
                        type="button"
                        class="btn-close"
                        aria-label="Закрыть"
                        @click="close"
                    ></button>
                </div>
                <form @submit.prevent="submit">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Заголовок</label>
                            <input
                                v-model="title"
                                type="text"
                                class="form-control"
                                :class="{ 'is-invalid': titleTouched && !isTitleValid }"
                                required
                            />
                            <div class="invalid-feedback">
                                Заголовок обязателен (минимум 3 символа).
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Содержимое</label>
                            <textarea
                                v-model="description"
                                rows="4"
                                class="form-control"
                                :class="{ 'is-invalid': contentTouched && !isContentValid }"
                                required
                            ></textarea>
                            <div class="invalid-feedback">
                                Содержимое обязательно (минимум 5 символов).
                            </div>
                        </div>

                        <div v-if="error" class="alert alert-danger">
                            {{ error }}
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="close">
                            Отмена
                        </button>
                        <button
                            type="submit"
                            class="btn btn-primary"
                            :disabled="loading"
                        >
                            {{ loading ? 'Сохранение…' : 'Сохранить' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, watch, computed } from 'vue';
import { useNotesStore } from '../stores/notesStore';
import type { Note } from '../stores/notesStore';

const props = defineProps<{
    visible: boolean;
    note: Note | null;
}>();

const emit = defineEmits<{
    (e: 'close'): void;
}>();

const store = useNotesStore();

const title = ref('');
const description = ref('');
const titleTouched = ref(false);
const contentTouched = ref(false);
const loading = ref(false);
const error = ref<string | null>(null);

const isTitleValid = computed(() => title.value.trim().length >= 3);
const isContentValid = computed(() => description.value.trim().length >= 5);
const isFormValid = computed(() => isTitleValid.value && isContentValid.value);

watch(
    () => props.note,
    (newNote) => {
        if (newNote) {
            title.value = newNote.title;
            description.value = newNote.description;
            titleTouched.value = false;
            contentTouched.value = false;
            error.value = null;
        }
    },
    { immediate: true }
);

async function submit() {
    if (!isFormValid.value) {
        titleTouched.value = true;
        contentTouched.value = true;
        return;
    }

    loading.value = true;
    error.value = null;
    try {
        if (!props.note) {
            throw new Error('Нет выбранной заметки');
        }
        await store.updateNote(props.note.id, {
            title: title.value,
            description: description.value,
        });
        close();
    } catch (e: unknown) {
        error.value = e instanceof Error ? e.message : 'Ошибка при обновлении';
    } finally {
        loading.value = false;
    }
}

function close() {
    emit('close');
}
</script>

<style scoped>
.modal.show {
    display: block;
    background: rgba(0, 0, 0, 0.5);
}
</style>