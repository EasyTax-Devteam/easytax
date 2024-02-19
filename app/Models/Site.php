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
        'instagram',
        'whatsapp',
        'privacy_policy',
        'terms',
    ];

    protected static function siteSettings()
    {
        $site = self::find(1);
        if (is_object($site)) {
            return $site->toArray();
        }
        return [
            'email' => null, 'support_email' => null, 'phone' => null, 'address' => null,
            'working_hours' => null, 'facebook' => null, 'twitter' => null, 'linkedin' => null, 'instagram' => null,
            'whatsapp' => null, 'privacy_policy' => null, 'terms' => null
        ];
    }

    public static function getSettings(){
        return json_decode(json_encode(self::siteSettings()));
    }
}
