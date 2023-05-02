<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\Values;
use Illuminate\Support\Facades\DB;

class ValuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('values')->insert([
            [
                'values_title' => "Our Core Values",
                'values_content' => "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Eget ac nisi, et pellentesque aenean sit vitae imperdiet maecenas. Sit elit nisi et quam quis. Pellentesque gravida rhoncus, in neque tincidunt leo sed massa. A nunc ut dignissim eget pulvinar amet aliquam vulputate.</p> \r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>",
                'is_definition' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
        DB::table('values')->insert([
            ['title' => "Holistic Solutions", 'description' => "At Ebeema, We have highly experienced and qualified teams to guide you through.", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => "Industry Expertise", 'description' => "At Ebeema, We have highly experienced and qualified teams to guide you through.", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => "Dedicated People", 'description' => "At Ebeema, We have highly experienced and qualified teams to guide you through.", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            
        ]);
    }
}
