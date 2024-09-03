<?php

namespace App\Domain\Course\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Domain\Course\DTO\CourseData;
use Illuminate\Support\Facades\Validator;
use App\Domain\Course\Services\CourseService;
use App\Domain\Course\Repositories\CourseRepository;
use App\Domain\Course\ViewModels\GetCourseReportViewModel;


class CourseController extends Controller
{
    private CourseRepository $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }
    public function index(Request $request): JsonResponse
    {
        // Repository Pattern

        // $courses = $this->courseRepository->findByPhoneAndTitle($request->phone, $request->title);        
        
        // OR Query Builder

        $courses = Course::query()
        ->wherePhoneAndTitle($request->phone, $request->title)
        ->get();


        return response()->json($courses);
    }
    public function store(Request $request, CourseService $courseService): JsonResponse 
    {
        if(Validator::make($request->all(), CourseData::rules())->fails()){
            return response()->json(['message' => 'Validation failed'], 422);
        }
        if( $courseService->create(CourseData::fromArray($request->all()))){
            return response()->json(['message' => 'Course created successfully'], 201);
        }
        return response()->json(['message' => 'Course creation failed'], 500);
        
    }
    public function stats(){
        return new GetCourseReportViewModel();
    }
}
