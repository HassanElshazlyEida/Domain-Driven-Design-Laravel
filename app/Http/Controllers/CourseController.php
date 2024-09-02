<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function store(Request $request): Course
    {
        DB::beginTransaction();
        try {
            $course = Course::create([
                'title'=>$request->title,
                'description'=>$request->description
            ]);
    
            foreach ($request->lessons as $lesson) {
                $course->lessons()->create([
                    'name'=>$lesson['name']
                ]);
            }
            foreach ($request->student_ids as $studentId) {
                $course->students()->attach($studentId);
            }
            return $course;
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            throw $e;

        }
    
    }
}
