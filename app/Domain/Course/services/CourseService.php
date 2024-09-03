<?php
namespace App\Domain\Course\Services;

use App\Models\Course;
use App\Domain\Course\DTO\CourseData;
use App\Domain\Course\Actions\NotifyUserAction;
use App\Domain\Course\Actions\CreateCourseAction;




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