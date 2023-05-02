<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('testimonials')->insert([
            ['image' => "",'designation' => 'developer','rating'=> '4', 'name' => "Bir Jung karki", 'comment' => "Ebeema, i think is only the insurance solution in context of Nepal. They provide excellent Service with 100% surety. My recommendation to everyone is that, do you insurance only with Ebeema.", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['image' => "",'designation' => 'Engineer','rating'=> '5', 'name' => "Rajani Shrestha", 'comment' => "Ebeema, i think is only the insurance solution in context of Nepal. They provide excellent Service with 100% surety. My recommendation to everyone is that, do you insurance only with Ebeema.", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['image' => "",'designation' => 'Client','rating'=> '3', 'name' => "Kripesh Bir Malakar", 'comment' => "Ebeema, i think is only the insurance solution in context of Nepal. They provide excellent Service with 100% surety. My recommendation to everyone is that, do you insurance only with Ebeema.", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['image' => "",'designation' => 'designer','rating'=> '4', 'name' => "Maya Karki", 'comment' => "Ebeema, i think is only the insurance solution in context of Nepal. They provide excellent Service with 100% surety. My recommendation to everyone is that, do you insurance only with Ebeema.", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ]);
    }
}
