<?php

namespace App\Models\Claim;

use App\Models\SPPA\Acceptance;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimAcceptance extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_polis',
        'product_id',
        'acceptance_id',
        'approval',
        'nama',
        'alamat',
        'file_polis',
        'berita_acara',
        'client_id',
        'customer_id',
        'claim_info_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'client_id',
        'acceptance_id',
        'customer_id',
        'claim_info_id',

    ];

    public function Acceptance()
    {
        return $this->hasOne(Acceptance::class, 'id', 'acceptance_id');
    }

    public function info()
    {
        return $this->hasOne(ClaimInfo::class, 'id', 'claim_info_id');
    }
}
