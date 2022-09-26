<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerReset extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'token',
        'active',
    ];
}
