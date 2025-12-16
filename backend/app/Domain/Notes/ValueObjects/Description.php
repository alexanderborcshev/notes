<?php
namespace App\Domain\Notes\ValueObjects;

use InvalidArgumentException;

final class Description
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty(trim($value))) {
            throw new InvalidArgumentException('Description cannot be empty');
        }
        $this->value = $value;
    }

    public function __toString(): string { return $this->value; }
}
