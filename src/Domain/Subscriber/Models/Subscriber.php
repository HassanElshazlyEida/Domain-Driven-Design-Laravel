<?php

namespace Domain\Subscriber\Models;

use Domain\Shared\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\LaravelData\WithData;
use Domain\Shared\Models\Concerns\HasUser;
use Domain\Subscriber\DataTransferObjects\SubscriberData;

class Subscriber extends BaseModel
{
    use WithData;
    use HasUser;  
    protected $dataClass = SubscriberData::class;
    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'form_id',
        'user_id',
    ];
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class)->withDefault();
    }

}