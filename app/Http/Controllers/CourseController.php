<?php

namespace App\Http\Controllers;

use App\DTO\CourseData;
use App\Models\Course;
use App\Services\CourseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
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
}
