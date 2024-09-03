<?php
namespace App\Services;

use App\DTO\CourseData;
use App\Models\Course;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CourseService {

    public function create(CourseData $data): Course | false{
        DB::beginTransaction();
        try {
            $course = Course::create($data->only(['title', 'description','phone']));
            $this->createLessons($course, $data->lessons);
            $this->assignStudents($course, $data->student_ids);
            $this->handlePhoneNumber($course, $data->phone);
            DB::commit();
            return $course; 
        }catch(Exception $e){
            throw $e;
            DB::rollBack();
            return false;
        }
    }

    public function createLessons(Course $course, Collection  $lessons): void{
        $lessons->each(fn($lesson) => $course->lessons()->create($lesson->toArray()));
    }
    public function assignStudents(Course $course, Collection $student_ids): void{
        $course->students()->attach($student_ids);
    }
    public function handlePhoneNumber(Course $course,  $phone): void {
        if ($this->isEgyptian($phone)) {
            // Perform some action if the phone number is Egyptian
        }

        if ($this->hasCountryCode($phone)) {
            // Perform some action if the phone number has a country code
        }

        // Save the phone number to the course
        $course->phone = $phone;
        $course->save();
    }
    public function isEgyptian($number): bool {
        return str_starts_with($number, '+20');
    }

    public function hasCountryCode($number): bool {
        return str_starts_with($number, '+');
    }
}