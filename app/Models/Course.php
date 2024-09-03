<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domain\Course\QueryBuilder\CourseBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;
    protected $fillable =[
        'title',
        'description',
        'phone'
    ];
    public function students(){
        return $this->belongsToMany(Student::class,'course_student','course_id','student_id');
    }
    public function lessons(){
        return $this->hasMany(Lesson::class);
    }

    public function newEloquentBuilder($query): CourseBuilder
    {
        return new CourseBuilder($query);
    }

}
