<?php
namespace App\Services;

use App\Models\Course;
use App\DTO\CourseData;
use App\Actions\NotifyUserAction;
use App\Actions\CreateCourseAction;


class CourseService {

    protected CreateCourseAction $createCourseAction;
    protected NotifyUserAction $notifyUserAction;

    public function __construct(CreateCourseAction $createCourseAction, NotifyUserAction $notifyUserAction)
    {
        $this->createCourseAction = $createCourseAction;
        $this->notifyUserAction = $notifyUserAction;
    }
    
    public function create(CourseData $data): Course | false{
        $course = ($this->createCourseAction)($data);
        if ($course) {
            ($this->notifyUserAction)($course);
        }
        return $course;
    }


}