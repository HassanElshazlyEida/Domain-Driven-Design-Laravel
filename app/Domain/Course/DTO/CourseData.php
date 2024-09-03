<?php
namespace App\Domain\Course\DTO;    


use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;
use Illuminate\Support\Collection;
use App\Domain\Course\DTO\LessonData;
use App\Domain\Course\ValueObjects\PhoneNumber;

class CourseData extends Data {
    public PhoneNumber $phone;
    public function __construct(
        public readonly ?int $id,
        public readonly string $title,
        string $phone,
        public readonly string $description,
        /** @var Collection<LessonData> */
        public readonly Lazy|Collection $lessons,

        /** @var Collection<int> */
        public readonly Lazy|Collection $student_ids
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
    public static function rules():array
    {
        return [
            'title' => 'required|string',
            'phone' => 'required|string',
            'description' => 'required|string',
            'lessons' => 'required|array',
            'lessons.*.name' => 'required|string',
            'student_ids' => 'required|array',
            'student_ids.*' => 'required|integer',
        ];
    }

  

}