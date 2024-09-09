<?php

namespace Domain\Network\Models;

use App\Observers\ContactObserver;
use Domain\Network\Entities\ContactEntity;
use Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\LaravelData\WithData;

class Contact extends Model
{
    use WithData;
    protected $dataClass = ContactEntity::class;
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'socials',
        'role',
        'pronouns',
        'birthday',
        'company_id',
        'user_id',
    ];

    protected $casts = [
        'socials' => 'array',
        'birthday' => 'datetime',
    ];

    // observer
    public static function boot()
    {
        parent::boot();
        static::observe(ContactObserver::class);
    }

    public function company() : BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
