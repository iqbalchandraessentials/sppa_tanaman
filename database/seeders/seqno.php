<?php

namespace Database\Seeders;

use App\Models\Seqno as ModelsSeqno;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class seqno extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seqno = [
            [
                'lno' => '/SPPA/',
                'cno' => 13,
                'type' => 'SPPA',
                'year' => '2022',
            ]
        ];

        ModelsSeqno::insert($seqno);
    }
}
