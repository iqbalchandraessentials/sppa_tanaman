<?php

namespace App\Models\SPPA;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'address',
        'phone',
        'active',
        'api_key',
        'distribution_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $hidden = array('api_key', 'email', 'address', 'phone', 'active', 'created_at', 'updated_at', 'distribution_id', 'id');
}
