<?php
namespace App\Application\Notes\CommandHandlers;

use App\Application\Notes\Commands\UpdateNoteCommand;
use App\Application\Notes\Services\NoteService;
use App\Domain\Notes\Entities\Note;
use App\Domain\Notes\Events\NoteUpdated;
use Illuminate\Contracts\Events\Dispatcher;

final readonly class UpdateNoteHandler
{
    public function __construct(
        private NoteService $service,
        private Dispatcher $dispatcher
    ) {}

    public function handle(UpdateNoteCommand $command): Note
    {
        $note = $this->service->update(
            $this->service->find($command->id),
            $command->title,
            $command->description
        );

        $this->dispatcher->dispatch(new NoteUpdated($note));
        return $note;
    }
}