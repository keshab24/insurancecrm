<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\AboutWe;
use Illuminate\Support\Facades\DB;

class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('about_wes')->insert([
            [
                'about_us_title' => "Nepal's first Insurance Agency that gives freedom to the customer to Compare and choose their own policy",
                'about_us_content' => "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Eget ac nisi, et pellentesque aenean sit vitae imperdiet maecenas. Sit elit nisi et quam quis. Pellentesque gravida rhoncus, in neque tincidunt leo sed massa. A nunc ut dignissim eget pulvinar amet aliquam vulputate.</p> \r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>",
                'is_definition' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
        DB::table('about_wes')->insert([
            ['image' => "", 'title' => "Expert People", 'description' => "At Ebeema, We have highly experienced and qualified teams to guide you through.", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['image' => "", 'title' => "Excellent Support", 'description' => "At Ebeema, We have highly experienced and qualified teams to guide you through.", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['image' => "", 'title' => "Industry Expert", 'description' => "At Ebeema, We have highly experienced and qualified teams to guide you through.", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            
        ]);
    }
}
