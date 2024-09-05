<?php

namespace Domain\Subscriber\Models;

use Domain\Shared\Models\BaseModel;
use Spatie\LaravelData\WithData;
use Domain\Shared\Models\Concerns\HasUser;

class Form extends BaseModel
{
    use WithData;
    use HasUser;
    
    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];

}