<?php
namespace App\Domain\Notes\Entities;

use App\Domain\Notes\ValueObjects\Title;
use App\Domain\Notes\ValueObjects\Description;
use DateTimeImmutable;

final class Note
{
    private int $id;
    private Title $title;
    private Description $description;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function __construct(
        int $id,
        Title $title,
        Description $description,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt
    ) {
        $this->id        = $id;
        $this->title     = $title;
        $this->description   = $description;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function id(): int { return $this->id; }
    public function title(): Title { return $this->title; }
    public function description(): Description { return $this->description; }
    public function createdAt(): DateTimeImmutable { return $this->createdAt; }
    public function updatedAt(): DateTimeImmutable { return $this->updatedAt; }

    public function update(Title $title, Description $description): void
    {
        $this->title   = $title;
        $this->description = $description;
        $this->updatedAt = new DateTimeImmutable();
    }
}
