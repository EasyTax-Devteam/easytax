<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderingField extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable = [
        'ordering_col',
        'ordering_dir',
        'target', // one of JOB, SLIDER, BLOG, CATEGORY, SERVICE, SERVICE_CATEGORY, TEAM
    ];

    public static function getDirections(){
        return [
            'asc' => 'Ascending', 
            'desc' => 'Descending',
        ];
    }

    public static function getOrdering($target = 'SLIDER'){
        return self::where('target', $target)->first();
    }
}
