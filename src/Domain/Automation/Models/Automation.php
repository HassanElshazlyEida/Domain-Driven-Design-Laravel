<?php

namespace Domain\Automation\Models;

use Domain\Shared\Models\BaseModel;

class Automation extends BaseModel
{
    protected $fillable = [
        'name',
        'user_id',
    ];
}