<?php

namespace App\Models\SPPA;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icover extends Model
{
    use HasFactory;

    protected $fillable = [
        'acceptance_id',
        'tsi',
        'description',
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
