<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaxCalendar extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'month',
        'title',
        'description',
        'theme', // color code
        'art_work',
        'is_active',
    ];

    public function days(): HasMany
    {
        return $this->hasMany(TaxCalendarDay::class);
    }

    public static function monthName($month_number){
        $dt = \DateTime::createFromFormat('!m', $month_number);
        return $dt->format('F');
    }


    public static function getCalendar(){
        return self::where('is_active', true)->orderBy('year')->orderBy('month')->get();
    }

}
