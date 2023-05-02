<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
            [
                'province_id' => '1',
                'city_name' => 'Biratnagar'
            ],
            [
                'province_id' => '1',
                'city_name' => 'Itahari'
            ],
            [
                'province_id' => '1',
                'city_name' => 'Dharan'
            ],
            [
                'province_id' => '1',
                'city_name' => 'Mechinagar'
            ],


            [
                'province_id' => '2',
                'city_name' => 'Janakpur'
            ],
            [
                'province_id' => '2',
                'city_name' => 'Birgunj'
            ],
            [
                'province_id' => '2',
                'city_name' => 'Kalaiya'
            ],
            [
                'province_id' => '2',
                'city_name' => 'Jitpursimara'
            ],

            [
                'province_id' => '3',
                'city_name' => 'Kathmandu'
            ],
            [
                'province_id' => '3',
                'city_name' => 'Lalitpur'
            ],
            [
                'province_id' => '3',
                'city_name' => 'Bharatpur'
            ],
            [
                'province_id' => '3',
                'city_name' => 'Hetauda'
            ],
            [
                'province_id' => '3',
                'city_name' => 'Budhanilkantha'
            ],
            [
                'province_id' => '3',
                'city_name' => 'Gokarneshwar'
            ],

            [
                'province_id' => '4',
                'city_name' => 'Pokhara'
            ],

            [
                'province_id' => '5',
                'city_name' => 'Butwal'
            ],
            [
                'province_id' => '5',
                'city_name' => 'Ghorahi'
            ],
            [
                'province_id' => '5',
                'city_name' => 'Nepalgunj'
            ],
            [
                'province_id' => '5',
                'city_name' => 'Tulsipur'
            ],

            [
                'province_id' => '6',
                'city_name' => 'Birendranagar'
            ],

            [
                'province_id' => '7',
                'city_name' => 'Dhangadhi'
            ],
        ]);
    }
}
