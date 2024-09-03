<?php

namespace App\Http\Controllers;

use App\DTO\CourseData;
use App\Models\Course;
use App\Repositories\CourseRepository;
use App\Services\CourseService;
use App\ViewModels\GetCourseReportViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
