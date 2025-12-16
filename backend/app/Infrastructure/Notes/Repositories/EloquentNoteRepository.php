<?php
namespace App\Infrastructure\Notes\Repositories;

use App\Domain\Notes\Entities\Note;
use App\Domain\Notes\Repositories\NoteRepositoryInterface;
use App\Infrastructure\Notes\Eloquent\Note as EloquentNote;
use App\Domain\Notes\ValueObjects\Title;
use App\Domain\Notes\ValueObjects\Description;
use DateMalformedStringException;
use DateTimeImmutable;

final class EloquentNoteRepository implements NoteRepositoryInterface
{
    public function all(): iterable
    {
        return EloquentNote::all()->map(fn ($e) => $this->toDomain($e));
    }

    /**
     * @throws DateMalformedStringException
     */
    public function find(int $id): ?Note
    {
        $e = EloquentNote::find($id);
        return $e ? $this->toDomain($e) : null;
    }

    /**
     * @throws DateMalformedStringException
     */
    public function save(Note $note): ?Note
    {
        $e = EloquentNote::find($note->id()) ?? new EloquentNote();
        $e->title   = (string) $note->title();
        $e->description = (string) $note->description();
        $e->save();
        return $e ? $this->toDomain($e) : null;
    }

    public function delete(Note $note): void
    {
        EloquentNote::destroy($note->id());
    }

    /**
     * @throws DateMalformedStringException
     */
    private function toDomain(EloquentNote $e): Note
    {
        return new Note(
            id: $e->id,
            title: new Title($e->title),
            description: new Description($e->description),
            createdAt: new DateTimeImmutable($e->created_at),
            updatedAt: new DateTimeImmutable($e->updated_at)
        );
    }
}
