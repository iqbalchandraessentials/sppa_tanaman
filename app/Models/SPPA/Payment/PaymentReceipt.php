<?php

namespace App\Models\SPPA\Payment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'acceptance_id',
        'no_arsip',
        'payment_date',
        'nominal',
        'information',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'no_arsip',
        'acceptance_id',
        'id'
    ];
}
