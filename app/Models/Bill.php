<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'order',
        'narration',
        'amount',
        'payment_status',
        'created_by',
        'mpesa_checkout_id',
        'mpesa_log',
    ];
}
