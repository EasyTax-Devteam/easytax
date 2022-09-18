<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'pin',
        'phone',
        'fname',
        'lname',
        'password',
        'itax_password',
    ];

    protected $hidden = [
        'password'
    ];
}
