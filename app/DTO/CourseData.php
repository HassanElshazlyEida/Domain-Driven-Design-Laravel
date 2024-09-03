<?php
namespace App\DTO;
use App\DTO\LessonData;
use Illuminate\Support\Collection;

class CourseData {
    public function __construct(
        public readonly ?int $id,
        public readonly string $title,
        public readonly string $description,
        public readonly string $phone,
        /** @var Collection<LessonData> */
        public readonly Collection $lessons,

        /** @var Collection<int> */
        public readonly Collection $student_ids
    )
    {}

    public static function fromArray(array $data): self {
        $lessons = collect($data['lessons'])->map(fn($lesson) => LessonData::fromArray($lesson));
        return new self(
            id: $data['id'] ?? null,
            title: $data['title'],
            description: $data['description'],
            phone: $data['phone'],
            lessons: $lessons,
            student_ids: collect($data['student_ids'])
        );
    }
    public function only(array $keys): array {
        return collect($this)->only($keys)->toArray();
    }
}