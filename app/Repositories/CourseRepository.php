<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseRepository
{
    public function findByPhoneAndTitle(?string $phone, ?string $title)
    {
        return DB::table('courses')
            ->where(function ($query) use ($phone, $title) {
                if ($phone) {
                    $query->where('phone', 'like', '%' . $phone . '%');
                }
                if ($title) {
                    $query->where('title', 'like', '%' . $title . '%');
                }
            })
            ->get();
    }
}
