<?php
namespace App\Domain\Notes\Repositories;

use App\Domain\Notes\Entities\Note;

interface NoteRepositoryInterface
{
    /** @return iterable<Note> */
    public function all(): iterable;

    public function find(int $id): ?Note;

    public function save(Note $note): void;

    public function delete(Note $note): void;
}
