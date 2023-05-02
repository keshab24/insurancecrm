<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                   'id'=>'1',
                'name' => 'super_admin',
                'display_name' => 'Super Admin',
                'description' => 'super_admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
'id'=>'2',
                'name' => 'administrator',
                'display_name' => 'admin',
                'description' => 'administrator',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
'id'=>'3',
                'name' => 'Staff',
                'display_name' => 'Staff',
                'description' => 'All the Staff that are logged in',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
'id'=>'4',
                'name' => 'user',
                'display_name' => 'User',
                'description' => 'this role belongs to all user',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
'id'=>'5',
                'name' => 'agent',
                'display_name' => 'Agent',
                'description' => 'this role belongs to all agent',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
