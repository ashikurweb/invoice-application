<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'number',
        'date',
        'due_date',
        'reference',
        'terms_and_conditions',
        'sub_total',
        'discount',
        'total',
    ];
}
