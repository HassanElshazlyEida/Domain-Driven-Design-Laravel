<?php
namespace App\DTO;
use App\DTO\LessonData;
use App\ValueObjects\PhoneNumber;
use Illuminate\Support\Collection;

class CourseData {
    public PhoneNumber $phone;
    public function __construct(
        public readonly ?int $id,
        public readonly string $title,
        string $phone,
        public readonly string $description,
        /** @var Collection<LessonData> */
        public readonly Collection $lessons,

        /** @var Collection<int> */
        public readonly Collection $student_ids
    )
    {
        $this->phone = PhoneNumber::from($phone);
    }

    public static function fromArray(array $data): self {
        $lessons = collect($data['lessons'])->map(fn($lesson) => LessonData::fromArray($lesson));
        return new self(
            id: $data['id'] ?? null,
            title: $data['title'],
            phone: $data['phone'],
            description: $data['description'],
            lessons: $lessons,
            student_ids: collect($data['student_ids'])
        );
    }
    public function only(array $keys): array {
        return collect($this)->only($keys)->toArray();
    }
}