<?php
namespace App\Domain\Notes\Events;

use App\Domain\Notes\Entities\Note;

final class NoteUpdated
{
    public Note $note;

    public function __construct(Note $note)
    {
        $this->note = $note;
    }
}
