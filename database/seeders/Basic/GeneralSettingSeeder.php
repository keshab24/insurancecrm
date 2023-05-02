<?php

namespace Database\Seeders\Basic;

use App\Models\GeneralSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Emptying the table
        DB::table('general_settings')->truncate();

        // Basic Data
        $settings = [
            [
                'key' => 'phone',
                'type' => 'contact',
                'value' => '+977 9803136585'
            ],
            [
                'key' => 'email',
                'type' => 'contact',
                'value' => 'hi@ebeema.com'
            ],
            [
                'key' => 'address',
                'type' => 'contact',
                'value' => 'Kamaladi Marg, Kamaladi, Kathmandu'
            ],
        ];

        foreach ($settings as $setting) {
            GeneralSetting::create($setting);
        }
    }
}
