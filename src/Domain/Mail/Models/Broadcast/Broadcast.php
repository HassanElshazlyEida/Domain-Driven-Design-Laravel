<?php

namespace Domain\Mail\Models\Broadcast;

use Domain\Mail\DataTransferObjects\Broadcast\BroadcastData;
use Domain\Mail\Models\Casts\FiltersCast;
use Domain\Mail\Enums\Broadcast\BroadcastStatus;
use Domain\Mail\DataTransferObjects\FilterData;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Concerns\HasUser;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\LaravelData\WithData;
use Illuminate\Contracts\Database\Query\Builder;

class Broadcast extends BaseModel
{
    use WithData;
    use HasUser;

    protected $dataClass = BroadcastData::class;

    protected $fillable = [
        'id',
        'subject',
        'content',
        'status',
        'filters',
        'sent_at',
        'user_id',
    ];

    protected $casts = [
        'filters' => FiltersCast::class,
        'status' => BroadcastStatus::class,
    ];

    protected $attributes = [
        'status' => BroadcastStatus::Draft,
    ];
}