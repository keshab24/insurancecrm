<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provinces')->insert([
            [
                'id' => '1',
                'province_name' => 'Province No. 1'
            ],
            [
                'id' => '2',
                'province_name' => 'Province No. 2'
            ],
            [
                'id' => '3',
                'province_name' => 'Bagmati Province'
            ],
            [
                'id' => '4',
                'province_name' => 'Gandaki Province'
            ],
            [
                'id' => '5',
                'province_name' => 'Lumbini Province'
            ],
            [
                'id' => '6',
                'province_name' => 'Karnali Province'
            ],
            [
                'id' => '7',
                'province_name' => 'Sudurpashchim Province'
            ],
        ]);
    }
}
