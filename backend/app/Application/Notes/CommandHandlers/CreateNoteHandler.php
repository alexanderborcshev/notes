<?php
namespace App\Application\Notes\CommandHandlers;

use App\Application\Notes\Commands\CreateNoteCommand;
use App\Application\Notes\Services\NoteService;
use App\Domain\Notes\Entities\Note;
use App\Domain\Notes\Events\NoteCreated;
use Illuminate\Contracts\Events\Dispatcher;

final readonly class CreateNoteHandler
{
    public function __construct(
        private NoteService $service,
        private Dispatcher $dispatcher
    ) {}

    public function handle(CreateNoteCommand $command): Note
    {
        $note = $this->service->create(
            $command->title,
            $command->description
        );

        $this->dispatcher->dispatch(new NoteCreated($note));

        return $note;
    }
}