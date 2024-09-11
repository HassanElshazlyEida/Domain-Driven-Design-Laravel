<?php

namespace Domain\Network\Models;

use App\Observers\ContactObserver;
use Carbon\Carbon;
use Domain\Network\Entities\ContactEntity;
use Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\LaravelData\WithData;

class Contact extends Model
{
    use WithData;
    use HasFactory;

    protected $dataClass = ContactEntity::class;
  

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
        'birthday' => 'datetime:Y-m-d H:i:s',
        'socials' => 'array',
    ];

    protected static function newFactory(){
        return \Database\Factories\Network\ContactFactory::new();
    }

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
