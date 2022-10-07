<?php

namespace App\Models\SPPA;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'email',
        'open_flag',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
