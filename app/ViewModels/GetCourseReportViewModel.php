<?php

namespace App\ViewModels;

use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Spatie\ViewModels\ViewModel;

class GetCourseReportViewModel extends ViewModel
{
    public function numCourses(): int
    {
        return Course::count();
    }

    public function numEgyptianCourses(): int
    {
        return Course::where('phone', 'like', '+20%')->count();
    }

    public function mostBookedCourses()
    {
        return DB::table('course_student')
            ->select('course_id', DB::raw('count(*) as total'))
            ->groupBy('course_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
    }
}
