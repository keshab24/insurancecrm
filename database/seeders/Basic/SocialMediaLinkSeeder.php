<?php

namespace Database\Seeders\Basic;

use App\Models\SocialLink;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SocialMediaLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Emptying the table
        DB::table('social_links')->truncate();

        // Basic Data
        $links = [
            [
                'title' => 'Facebook',
                'link' => 'https://facebook.com',
                'icon' => 'fa fa-facebook',
                'position' => 1,
            ],
            [
                'title' => 'Instagram',
                'link' => 'https://instagram.com',
                'icon' => 'fa fa-instagram',
                'position' => 2,
            ],
            [
                'title' => 'Twitter',
                'link' => 'https://twitter.com',
                'icon' => 'fa fa-twitter',
                'position' => 3,
            ],
            [
                'title' => 'LinkedIn',
                'link' => 'https://linkedin.com',
                'icon' => 'fa fa-linkedin',
                'position' => 4,
            ]
        ];

        foreach ($links as $link) {
            SocialLink::create($link);
        }
    }
}
