<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer',
        'pin',
        'itax_password',
        'has_taxable_income',
        'paying_kenyan_insurance_policies',
        'kenyan_insurance_policies_paid',
        'paid_mortgage_for_tax_year',
        'p_nine_form',
        'income_and_expenses_schedule',
        'financial_statements',
        'service'
    ];
}
