<?php
namespace App\Application\Notes\Commands;

use App\Domain\Notes\ValueObjects\Title;
use App\Domain\Notes\ValueObjects\Description;

final class CreateNoteCommand
{
    public Title $title;
    public Description $description;

    public function __construct(string $title, string $description)
    {
        $this->title = new Title($title);
        $this->description = new Description($description);
    }
}
