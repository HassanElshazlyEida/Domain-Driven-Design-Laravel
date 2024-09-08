<?php

namespace Domain\Subscriber\Models;

use Spatie\LaravelData\WithData;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Concerns\HasUser;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Domain\Subscriber\DataTransferObjects\SubscriberData;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subscriber extends BaseModel
{
    use WithData;
    use HasUser;  
    protected $dataClass = SubscriberData::class;
    protected $table = 'subscribers';
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
    public function fullName(): Attribute
    {
        return new Attribute(
            get: fn() => "{$this->first_name} {$this->last_name}",
        );
    }
}