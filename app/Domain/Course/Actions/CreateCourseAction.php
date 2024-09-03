<?php

namespace App\Domain\Course\Actions;

use Exception;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use App\Domain\Course\DTO\CourseData;
use App\Domain\Course\ValueObjects\PhoneNumber;



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
