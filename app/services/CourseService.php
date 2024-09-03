<?php
namespace App\Services;

use App\DTO\CourseData;
use App\Models\Course;
use App\ValueObjects\PhoneNumber;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CourseService {

    public function create(CourseData $data): Course | false{
        DB::beginTransaction();
        try {
            $course = Course::create($data->only('title', 'description','phone')->toArray());
            $this->createLessons($course, $data->lessons);
            $this->assignStudents($course, $data->student_ids);
            $this->handlePhoneNumber($course, $data->phone);
            
            Mail::to('someuser@gmail.com')->send(new \App\Mail\CourseNotification($course));

            DB::commit();
            return $course; 
        }catch(Exception $e){
            throw $e;
            DB::rollBack();
            throw $e;
            return false;
        }
    }

    public function createLessons(Course $course, Collection  $lessons): void{
        $lessons->each(fn($lesson) => $course->lessons()->create($lesson->toArray()));
    }
    public function assignStudents(Course $course, Collection $student_ids): void{
        $course->students()->attach($student_ids);
    }
    public function handlePhoneNumber(Course $course, PhoneNumber $phone): void {
        if ($phone->isEgyptian()) {
            // Perform some action if the phone number is Egyptian
        }

        if ($phone->hasCountryCode()) {
            // Perform some action if the phone number has a country code
        }

        // Save the phone number to the course
        $course->phone = $phone;
        $course->save();
    }
    
}