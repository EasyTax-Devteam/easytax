<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'support_email',
        'phone',
        'address',
        'working_hours',
        'facebook',
        'twitter',
        'linkedin',
        'instagram'
    ];
}
