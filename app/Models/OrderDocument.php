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

    public static function getReturnDocs($order)
    {
        $data = OrderDocument::where('order', $order)->get();
        if (is_object($data)) {
            return $data->toArray();
        }
        return [];
    }
}
