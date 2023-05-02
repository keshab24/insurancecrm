<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\WhyUs;
use Illuminate\Support\Facades\DB;

class WhyUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('why_us')->insert([
            [
                'why_us_title' => "Nepal's first Insurance Agency that gives freedom to the customer to Compare and choose their own policy",
                'why_us_content' => "<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab, alias, minima! Assumenda blanditiis culpa deserunt doloribus explicabo fuga nam non quia, voluptatem voluptates! Debitis dolor, dolore ipsum iusto rerum vitae!.</p> \r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>",
                'is_definition' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
        DB::table('why_us')->insert([
            ['image' => "", 'title' => "MONEY BACK GURANTEES", 'description' => "We are committed to provide quality service.", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['image' => "", 'title' => "NO POLICY FEES", 'description' => "We are committed to provide quality service.", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['image' => "", 'title' => "ONLINE SERVICES", 'description' => "We are committed to provide quality service.", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['image' => "", 'title' => "TRUSTWORTHY COMPANY", 'description' => "We are committed to provide quality service.", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ]);
    }
}
