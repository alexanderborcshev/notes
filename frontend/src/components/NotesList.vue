<template>
    <div class="list-group">
        <div
            v-for="note in notes"
            :key="note.id"
            class="list-group-item list-group-item-action flex-column align-items-start"
        >
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">{{ note.title }}</h5>
                <small>{{ formatDate(note.date) }}</small>
            </div>
            <p class="mb-1 text-start">{{ note.description }}</p>

            <div class="d-flex gap-2 mt-2">
                <button
                    class="btn btn-sm btn-outline-secondary"
                    @click="openEditModal(note)"
                >
                    Редактировать
                </button>

                <button
                    class="btn btn-sm btn-outline-danger"
                    @click="removeNote(note.id)"
                >
                    Удалить
                </button>
            </div>
        </div>

        <div v-if="loading" class="text-center py-3">Загрузка…</div>
        <div v-else-if="notes.length === 0" class="text-center py-3">Список заметок пуст</div>
        <div v-if="error" class="alert alert-danger mt-2">{{ error }}</div>
    </div>

    <EditNoteModal
        :visible="showEditModal"
        :note="editingNote"
        @close="closeEditModal"
    />
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import {type Note, useNotesStore} from '../stores/notesStore';
import EditNoteModal from '../components/EditNoteModal.vue';

const store = useNotesStore();

const notes = computed(() => store.notes);
const loading = computed(() => store.loading);
const error = computed(() => store.error);

const removeNote = (id: number) => store.removeNote(id);

const editingNote = ref<Note | null>(null);
const showEditModal = ref(false);

const openEditModal = (note: Note) => {
    editingNote.value = note;
    showEditModal.value = true;
};

const closeEditModal = () => {
    showEditModal.value = false;
    editingNote.value = null;
};

function formatDate(d: Date | string | null | undefined): string {
    if (!d) return '';
    const dateObj = d instanceof Date ? d : new Date(d);
    if (isNaN(dateObj.getTime())) return '';
    return new Intl.DateTimeFormat('ru-RU', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    }).format(dateObj);
}

onMounted(() => store.fetchNotes());
</script>

<style scoped>
</style>