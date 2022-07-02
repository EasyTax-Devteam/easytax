<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'service',
        'field_label',
        'field_is_required',
        'field_name',
        'field_id',
        'field_placeholder',
        'field_default_value',
        'field_type',
        'field_is_multiple',
        'field_max_uploads',
        'field_options_json',
        'field_form_code',
        'order',
        'validation_rule'
    ];
}
