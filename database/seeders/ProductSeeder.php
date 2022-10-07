<?php

namespace Database\Seeders;

use App\Models\SPPA\Product;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = [
            [
                'product_code' => 'GTI',
                'product_name' => 'Growing Trees Insurance (Asuransi Tanaman)',
                'created_at' => Carbon::now()
            ]
        ];

        Product::insert($product);
    }
}
