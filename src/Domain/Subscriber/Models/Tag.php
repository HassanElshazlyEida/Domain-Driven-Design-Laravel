<?php

namespace Domain\Subscriber\Models;

use Spatie\LaravelData\WithData;
use Domain\Shared\Models\BaseModel;
use Domain\Subscriber\Models\Subscriber;
use Domain\Shared\Models\Concerns\HasUser;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Domain\Subscriber\DataTransferObjects\TagData;

class Tag extends BaseModel
{
    use WithData;
    use HasUser;

    protected $dataClass = TagData::class;

    protected $fillable = [
        'title',
        'user_id',
    ];

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(Subscriber::class);
    }

}