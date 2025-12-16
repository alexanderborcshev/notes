<?php
namespace App\Application\Notes\Services;

use App\Domain\Notes\Entities\Note;
use App\Domain\Notes\Repositories\NoteRepositoryInterface;
use App\Domain\Notes\ValueObjects\Title;
use App\Domain\Notes\ValueObjects\Description;
use DateTimeImmutable;

final readonly class NoteService
{
    public function __construct(private NoteRepositoryInterface $repository) {}

    public function create(Title $title, Description $description): Note
    {
        $note = new Note(
            id: 0,
            title: $title,
            description: $description,
            createdAt: new DateTimeImmutable(),
            updatedAt: new DateTimeImmutable()
        );
        return $this->repository->save($note);
    }

    public function update(Note $note, Title $title, Description $description): Note
    {
        $note->update($title, $description);
        $this->repository->save($note);
        return $note;
    }

    public function find(int $id): ?Note
    {
        return $this->repository->find($id);
    }

    public function delete(Note $note): void
    {
        $this->repository->delete($note);
    }

    /** @return iterable<Note> */
    public function all(): iterable
    {
        return $this->repository->all();
    }
}
