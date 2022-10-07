<?php

namespace App\Models\SPPA;

use App\Models\SPPA\Payment\PaymentReceipt;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acceptance extends Model
{
    use HasFactory;

    protected $fillable = [
        'regno',
        'policy_no',
        'sdate',
        'edate',
        'jenis_cover',
        'approval',
        'product_id',
        'customer_id',
        'client_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'product_id',
        'policy_no',
        'customer_id',
        'client_id',
    ];

    public function ainfo()
    {
        return $this->hasOne(Ainfo::class, 'acceptance_id', 'id');
    }

    public function r_cover()
    {
        return $this->hasMany(Rcover::class, 'acceptance_id', 'id');
    }

    public function i_cover()
    {
        return $this->hasOne(Icover::class, 'acceptance_id', 'id');
    }
    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function client()
    {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }
    public function payment()
    {
        return $this->hasOne(PaymentReceipt::class, 'id', 'client_id');
    }
}
