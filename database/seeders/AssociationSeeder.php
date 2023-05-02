<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssociationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('associations')->insert([
            ['image' => "",'association_type' => '1','status' => '1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['image' => "",'association_type' => '1','status' => '1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['image' => "",'association_type' => '2','status' => '1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['image' => "",'association_type' => '2','status' => '1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ]);
    }
}
