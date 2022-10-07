<?php

namespace App\Models\Claim;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'lokasi_pertanggungan',
        'penyebab_kerugian',
        'tanggal_kerugian',
        'waktu_kerugian',
        'kronologi',
        'okupasi_harta_peristiwa',
        'harta_tercantum_polis',
        'perubahan_okupasi_harta',
        'nilai_sebelum_peristiwa',
        'nilai_setelah_peristiwa',
        'pernah_terjadi_kerugian',
        'memiliki_asuransi_lain',
        'syarat_terpenuhi',
        'pihaklain_terhadap_harta',
        'keterangan',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'id'
    ];
}
