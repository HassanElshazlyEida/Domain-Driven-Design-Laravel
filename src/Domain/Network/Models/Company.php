<?php

namespace Domain\Network\Models;

use Spatie\LaravelData\WithData;
use Illuminate\Database\Eloquent\Model;
use Domain\Network\Entities\CompanyEntity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use WithData;
    use HasFactory;

    protected $dataClass = CompanyEntity::class;
    protected $fillable = [
        'name',
        'logo',
        'website',
        'industry',
        'email',
        'description',
        'socials',
        'user_id',
   
    ];
    protected $casts = [
        'socials' => 'array',
    ];
    protected static function newFactory(){
        return \Database\Factories\Network\CompanyFactory::new();
    }
}
