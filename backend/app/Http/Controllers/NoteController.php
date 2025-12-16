<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use Illuminate\Http\JsonResponse;

class NoteController extends Controller
{
    public function __construct()
    {
        NoteResource::withoutWrapping();
    }
    public function index(): JsonResponse
    {
        return NoteResource::collection(Note::all())->response();
    }

    public function store(StoreNoteRequest $request): NoteResource
    {
        $note = Note::create($request->validated());
        return new NoteResource($note);
    }

    public function update(UpdateNoteRequest $request, Note $note): NoteResource
    {
        $note->update($request->validated());

        return new NoteResource($note);
    }

    public function destroy(Note $note)
    {
        $note->delete();
    }
}
