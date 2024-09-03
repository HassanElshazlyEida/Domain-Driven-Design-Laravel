<?php

namespace App\Actions;
use App\DTO\CourseData;
use App\Models\Course;
use App\ValueObjects\PhoneNumber;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CreateCourseAction
{
    public function __invoke(CourseData $data): Course | false
    {
        DB::beginTransaction();
        try {
            $course = Course::create($data->only('title', 'description','phone')->toArray());

            $data->lessons->each(fn($lesson) => $course->lessons()->create($lesson->toArray()));

            $course->students()->attach($data->student_ids);
            
            $this->handlePhoneNumber($course, $data->phone);
            
            DB::commit();
            return $course; 
        }catch(Exception $e){
            DB::rollBack();
            // throw $e;
            return false;
        }
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
