<?php
namespace App\Providers;

use App\Domain\Notes\Repositories\NoteRepositoryInterface;
use App\Infrastructure\Notes\Repositories\EloquentNoteRepository;
use Illuminate\Support\ServiceProvider;

final class NotesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(NoteRepositoryInterface::class, EloquentNoteRepository::class);
    }
}
