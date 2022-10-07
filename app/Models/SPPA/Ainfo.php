<?php

namespace App\Models\SPPA;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ainfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'acceptance_id',
        'valueid1',
        'valuedesc1',
        'valueid2',
        'valuedesc2',
        'valueid3',
        'valuedesc3',
        'valueid4',
        'valuedesc4',
        'valueid5',
        'valuedesc5',
        'valueid6',
        'valuedesc6',
        'valueid7',
        'valuedesc7',
        'valueid8',
        'valuedesc8',
        'valueid9',
        'valuedesc9',
        'valueid10',
        'valuedesc10',
        'valueid11',
        'valuedesc11',
        'valueid12',
        'valuedesc12',
        'valueid13',
        'valuedesc13',
        'valueid14',
        'valuedesc14',
        'valueid15',
        'valuedesc15',
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
