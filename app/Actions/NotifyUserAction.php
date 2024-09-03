<?php

namespace App\Actions;

use App\Models\Course;
use Illuminate\Support\Facades\Mail;

class NotifyUserAction
{
    public function __invoke(Course $course): void
    {
        Mail::to($course->user->email)->send(new \App\Mail\CourseNotification($course));
    }
}
