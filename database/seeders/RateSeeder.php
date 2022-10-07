<?php

namespace Database\Seeders;

use App\Models\SPPA\Rates;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rates = [
            [
                'rate_code' => 'FLEXAS',
                'rate' => 0.3,
                'description' => 'flexas',
                'created_at' => date('Y-m-d H:i:s', time()),
                'product_id' => 1,
                'main' => 'Y',
                'unit' => 'C'
            ],
            [
                'rate_code' => 'Hama',
                'rate' => 0.025,
                'description' => 'Hama',
                'created_at' => date('Y-m-d H:i:s', time()),
                'product_id' => 1,
                'main' => 'N',
                'unit' => 'C'

            ],
            [
                'rate_code' => 'Penyakit',
                'rate' => 0.075,
                'description' => 'Penyakit',
                'created_at' => date('Y-m-d H:i:s', time()),
                'product_id' => 1,
                'main' => 'N',
                'unit' => 'C'

            ],
            [
                'rate_code' => 'RSMDCC',
                'rate' => 0.025,
                'description' => 'RSMDCC',
                'created_at' => date('Y-m-d H:i:s', time()),
                'product_id' => 1,
                'main' => 'N',
                'unit' => 'C'
            ],
        ];

        Rates::insert($rates);
    }
}
