<?php

namespace App\Domain\Course\DTO;

class LessonData
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?int $course_id
    )
    {
        
    }

    public static function  fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'],
            course_id: $data['course_id'] ?? null
        );
    }
    public function toArray(): array
    {
        return collect($this)->toArray();
    }
}
