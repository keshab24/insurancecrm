<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teams')->insert([
            ['image' => "",'designation' => 'CEO', 'name' => "Rajesh Shrestha", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['image' => "",'designation' =>'management', 'name' => "Dhiraj Thapa", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['image' => "",'designation' => 'management', 'name' => "Siddharth Baduwal", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
           
        ]);
    }
}
