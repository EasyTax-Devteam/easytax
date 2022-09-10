<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'order',
        'title',
        'path',
        'uploaded_by'
    ];
}
