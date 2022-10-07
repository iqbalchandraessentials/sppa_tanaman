<?php

namespace App\Models\SPPA;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rcover extends Model
{
    use HasFactory;

    protected $fillable = [
        'acceptance_id',
        'rate_code',
        'rate',
        'scaling',
        'premium',
        'unit',
        'description',
        'sdate',
        'edate',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'id',
        'created_at', 'updated_at',
        'acceptance_id'
    ];
}
