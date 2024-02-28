<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'prefix',
        'title',
        'description',
        'image',
        'url',
        'button_text',
        'order',
    ];

    public static function getSliders(){
        return Slider::orderBy('order', 'asc')->get();
    }
}
