<?php

namespace Domain\Automation\Models;

use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Concerns\HasUser;
use Spatie\LaravelData\WithData;

class Automation extends BaseModel
{
    use WithData;
    use HasUser;


    protected $fillable = [
        'name',
        'user_id',
    ];
}