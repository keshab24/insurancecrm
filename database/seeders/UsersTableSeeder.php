<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'role_id' => '1',
                'username' => 'superadmin',
                'password' => bcrypt('secret123'),
                'email' => 'superadmin@gmail.com',
                'designation' => 'Super Admin',
                'is_active' => '1',
                'image_icon' => null,
                'remember_token' => Str::random(60),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'role_id' => '2',
                'username' => 'admin',
                'password' => bcrypt('password12345'),
                'email' => 'admin@admin.com',
                'designation' => 'Admin',
                'is_active' => '1',
                'image_icon' => null,
                'remember_token' => Str::random(60),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'role_id' => '3',
                'username' => 'staff',
                'password' => bcrypt('password12345'),
                'email' => 'staff@staff.com',
                'designation' => 'Staff',
                'is_active' => '1',
                'image_icon' => null,
                'remember_token' => Str::random(60),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
            ,
            [
                'role_id' => '4',
                'username' => 'user',
                'password' => bcrypt('password12345'),
                'email' => 'user@user.com',
                'designation' => 'User',
                'is_active' => '1',
                'image_icon' => null,
                'remember_token' => Str::random(60),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
