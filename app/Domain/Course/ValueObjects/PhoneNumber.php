<?php

namespace App\Domain\Course\ValueObjects;

class PhoneNumber
{
    public function __construct(
        public readonly string $number
    )
    {
    }

    public function __toString(): string
    {
        return $this->number;
    }
    public function isEgyptian(): bool {
        return str_starts_with($this->number, '+20');
    }

    public function hasCountryCode(): bool {
        return str_starts_with($this->number, '+');
    }

    public static function from(string $number): self {
        return new self($number);
    }
}
