<?php

namespace Domain\Mail\Models\Sequence;

use Domain\Mail\Enums\Sequence\SequenceStatus;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Concerns\HasUser;
use Spatie\LaravelData\WithData;

class Sequence extends BaseModel
{
    use HasUser;
    protected $fillable = [
        'title',
        'status',
        'user_id',
    ];

    protected $casts = [
        'status' => SequenceStatus::class,
    ];

    protected $attributes = [
        'status' => SequenceStatus::Draft,
    ];

}