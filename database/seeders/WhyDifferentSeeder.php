<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WhyDifferentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('why_differents')->insert([
            [
                'why_diff_title' => "Why we are <br> different ?",
                'why_diff_content' => "A team of determined, passionate, and crazy entrepreneurs, developers, and financial engineers set out on one common mission - To make financial and insurance services accessible, simple, and seamless.To make financial and insurance services accessible, simple, and seamless.",
                'is_definition' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
        DB::table('why_differents')->insert([
            ['image' => "", 'title' => "Unbiased results", 'description' => "you can trust us to give you the best advice for your insurance", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['image' => "", 'title' => "Simple", 'description' => "It is a simple to use as we make it clear to you what you will receive with each plan through our calculator.", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['image' => "", 'title' => "Reliable", 'description' => "Our advisors at Ebeema will make sure that you are not rushed or pushed into sales", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['image' => "", 'title' => "Claims", 'description' => "We have a claim support team who will help you while filing for a claim", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ]);
    }
}
