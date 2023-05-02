<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PolicyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('policy_categories')->insert([
            [
                'id' => '1',
                'name' => 'Life'
            ],
            [
                'id' => '2',
                'name' => 'Non Life'
            ],
        ]);
    }
}
