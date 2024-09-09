<?php

namespace Domain\Network\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
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
}
