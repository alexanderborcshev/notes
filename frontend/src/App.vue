<script setup lang="ts">
    import NotesList from './components/NotesList.vue';
    import AddNoteForm from './components/AddNoteForm.vue';
</script>

<template>
    <div class="container py-4">
        <h1 class="mb-4">Мои заметки</h1>
        <div class="row">
            <div class="col-8">
                <NotesList />
            </div>
            <div class="col-4">
                <AddNoteForm />
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
