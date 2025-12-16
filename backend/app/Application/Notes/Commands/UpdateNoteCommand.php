<?php
namespace App\Application\Notes\Commands;

use App\Domain\Notes\ValueObjects\Title;
use App\Domain\Notes\ValueObjects\Description;

final readonly class UpdateNoteCommand
{
    public int $id;
    public Title $title;
    public Description $description;

    public function __construct(int $id, string $title, string $description)
    {
        $this->id = $id;
        $this->title = new Title($title);
        $this->description = new Description($description);
    }
}
