<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxCalendarDayEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'tax_calendar_day_id',
        'title',
        'content',
    ];
}
