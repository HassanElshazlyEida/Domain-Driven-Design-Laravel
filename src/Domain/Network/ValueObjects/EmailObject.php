<?php

namespace Domain\Network\ValueObjects;

class EmailObject
{
    public ?string $email;

    public function __construct(string $email)
    {
        if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email address');
        }
        $this->email = $email;
    }

    public function __toString(): string
    {
        return $this->email;
    }
    public static function from(string $email): self
    {
        return new self($email);
    }
}
