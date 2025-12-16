import { defineStore } from 'pinia';
import { ref } from 'vue';
import axios from 'axios';

export interface Note {
    id: number;
    title: string;
    description: string;
    date: Date;
}

const api = axios.create({
    baseURL: 'http://localhost:8080/api', // ← ваш endpoint
    timeout: 5_000,
    headers: { 'Content-Type': 'application/json' },
});

export const useNotesStore = defineStore('notes', () => {
    const notes   = ref<Note[]>([]);
    const loading = ref(false);
    const error   = ref<string | null>(null);

    /** Получить список заметок */
    const fetchNotes = async () => {
        loading.value = true;
        error.value   = null;
        try {
            const { data } = await api.get<Note[]>('/notes');
            notes.value = data.map(n => ({
                ...n,
                date: n.date instanceof Date ? n.date : new Date(n.date)
            }));
        } catch (e: unknown) {
            if (axios.isAxiosError(e)) {
                error.value = e.response?.data?.message || e.message;
            } else {
                error.value = 'Неизвестная ошибка';
            }
        } finally {
            loading.value = false;
        }
    };

    /** Добавить заметку */
    const addNote = async (payload: Omit<Note, 'id' | 'date'>) => {
        error.value = null;
        try {
            const { data } = await api.post<Note>('/notes', payload);
            notes.value.push({ ...data, date: new Date(data.date) });
        } catch (e: unknown) {
            if (axios.isAxiosError(e)) {
                error.value = e.response?.data?.message || e.message;
            } else {
                error.value = 'Не удалось добавить заметку';
            }
        }
    };

    /** Удалить заметку по id */
    const removeNote = async (id: number) => {
        error.value = null;
        try {
            await api.delete(`/notes/${id}`);
            notes.value = notes.value.filter(n => n.id !== id);
        } catch (e: unknown) {
            if (axios.isAxiosError(e)) {
                error.value = e.response?.data?.message || e.message;
            } else {
                error.value = 'Не удалось удалить заметку';
            }
        }
    };

    /** Обновить заметку  */
    const updateNote = async (
        id: number,
        updates: Partial<Omit<Note, 'id' | 'date'>>
    ) => {
        error.value = null;
        try {
            const { data } = await api.put<Note>(`/notes/${id}`, updates);
            const idx = notes.value.findIndex(n => n.id === id);
            if (idx !== -1) notes.value[idx] = data;
        } catch (e: unknown) {
            if (axios.isAxiosError(e)) {
                error.value = e.response?.data?.message || e.message;
            } else {
                error.value = 'Не удалось обновить заметку';
            }
        }
    };

    return {
        notes,
        loading,
        error,
        fetchNotes,
        addNote,
        removeNote,
        updateNote,
    };
});