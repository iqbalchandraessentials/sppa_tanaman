<?php

namespace App\Models\SPPA;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'place_of_birth',
        'date_of_birth',
        'identity_type',
        'identity_no',
        'address',
        'home_phone',
        'office_phone',
        'handphone',
        'fax_no',
        'NPWP',
        'citizen',
        'source_premium_payment',
        'individual',
        'valueid1',
        'valuedesc1',
        'valueid2',
        'valuedesc2',
        'valueid3',
        'valuedesc3',
        'valueid4',
        'valuedesc4',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];
}
