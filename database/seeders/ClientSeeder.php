<?php

namespace Database\Seeders;

use App\Models\SPPA\Client;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = [
            [
                'name' => 'Sinar Jaya',
                'email' => 'iqbalganteng@gmail.com',
                'address' => 'tampan dan rupawan',
                'phone' => '081210688545',
                'active' => 'Y',
                'api_key' => '856101',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Terang Bulan',
                'email' => 'bbc@gmail.com',
                'address' => 'garut west java',
                'phone' => '081210688545',
                'active' => 'Y',
                'api_key' => '123456',
                'created_at' => Carbon::now()
            ],
        ];
        Client::insert($clients);
    }
}
