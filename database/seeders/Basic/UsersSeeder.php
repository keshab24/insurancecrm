<?php

namespace Database\Seeders\Basic;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Emptying the table
        DB::table('users')->truncate();

        // Basic Data
        $users = [
            [
                'role_id' => '1',
                'username' => 'superadmin',
                'password' => bcrypt('secret123'),
                'email' => 'superadmin@gmail.com',
                'designation' => 'Super Admin',
                'is_active' => '1',
                'image_icon' => null,
                'remember_token' => Str::random(60),
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
