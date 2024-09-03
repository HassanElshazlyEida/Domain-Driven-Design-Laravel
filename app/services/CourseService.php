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
            $course = Course::create($data->only(['title', 'description']));
            $this->createLessons($course, $data->lessons);
            $this->assignStudents($course, $data->student_ids);
            DB::commit();
            return $course; 
        }catch(Exception $e){
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
    
}