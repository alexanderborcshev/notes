<?php
namespace App\Http\Controllers;

use App\Application\Notes\CommandHandlers\UpdateNoteHandler;
use App\Application\Notes\CommandHandlers\CreateNoteHandler;
use App\Application\Notes\Commands\CreateNoteCommand;
use App\Application\Notes\Commands\UpdateNoteCommand;
use App\Application\Notes\Services\NoteService;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Http\Resources\NoteResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class NoteController extends Controller
{
    public function __construct(
        private readonly NoteService $service,
        private readonly CreateNoteHandler $createHandler,
        private readonly UpdateNoteHandler $updateHandler
    ) {}

    public function index(): JsonResponse
    {
        $notes = $this->service->all();
        NoteResource::withoutWrapping();
        return NoteResource::collection($notes)->response();
    }

    public function store(StoreNoteRequest $request): NoteResource
    {
        $command = new CreateNoteCommand(
            $request->validated()['title'],
            $request->validated()['description']
        );
        $note = $this->createHandler->handle($command);

        NoteResource::withoutWrapping();
        return new NoteResource($note);
    }

    public function update(UpdateNoteRequest $request, $id): NoteResource
    {
        $command = new UpdateNoteCommand(
            $id,
            $request->validated()['title'],
            $request->validated()['description']
        );

        $note = $this->updateHandler->handle($command);

        NoteResource::withoutWrapping();
        return new NoteResource($note);
    }

    public function destroy($id): Response
    {
        $note = $this->service->find($id);
        if ($note === null) {
            return response()->noContent()->setStatusCode(404);
        }
        $this->service->delete($this->service->find($id));
        return response()->noContent();
    }
}