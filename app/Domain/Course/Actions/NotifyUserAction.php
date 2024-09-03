<?php

namespace App\Domain\Course\Actions;

use App\Models\Course;
use Illuminate\Support\Facades\Mail;
use App\Domain\Course\Mail\CourseNotification;

class NotifyUserAction
{
    public function __invoke(Course $course): void
    {
        Mail::to($course->user->email)->send(new CourseNotification($course));
    }
}
