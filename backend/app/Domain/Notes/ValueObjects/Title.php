<?php
namespace App\Domain\Notes\ValueObjects;

use InvalidArgumentException;

final class Title
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty(trim($value))) {
            throw new InvalidArgumentException('Title cannot be empty');
        }
        if (strlen($value) > 255) {
            throw new InvalidArgumentException('Title cannot be longer than 255 characters');
        }
        $this->value = $value;
    }

    public function __toString(): string { return $this->value; }
}
