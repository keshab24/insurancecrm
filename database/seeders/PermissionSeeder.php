<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
'id'=>'1',
                'name' => 'frontend-dynamics',
                'display_name' => 'frontend dynamic',
                'description' => 'frontend Panel Access Permission!!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
'id'=>'2',
                'name' => 'create-user',
                'display_name' => 'Create User',
                'description' => 'Permission for creating users',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
'id'=>'3',
                'name' => 'rate-import',
                'display_name' => 'Rate import',
                'description' => 'Permission to import rates',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
'id'=>'4',
                'name' => 'create-leads',
                'display_name' => 'Create Leads',
                'description' => 'To control leads',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
'id'=>'5',
                'name' => 'create-policy	',
                'display_name' => 'Create Policy',
                'description' => 'Permission for creating policy',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
'id'=>'6',
                'name' => 'create-calendar',
                'display_name' => 'Create calendar',
                'description' => 'Permission for creating calendar',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
'id'=>'7',
                'name' => 'premium-calculation',
                'display_name' => 'premium calculation',
                'description' => 'Permission for calculating Premiun',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
'id'=>'8',
                'name' => 'permission-create',
                'display_name' => 'permission Access',
                'description' => 'Permission for Accesing Permission',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
'id'=>'9',
                'name' => 'create-product',
                'display_name' => 'Product Access',
                'description' => 'permission to access Product',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
'id'=>'10',
                'name' => 'create-company',
                'display_name' => 'Company Access',
                'description' => 'Permission for Accesing Company',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
        DB::table('permission_role')->insert([
            [
                "permission_id" => "1",
              "role_id" => "1"
           ],
           [
               "permission_id" => "2",
              "role_id" => "1"
            ],
           [
               "permission_id" => "3",
              "role_id" => "1"
            ],
           [
               "permission_id" => "4",
              "role_id" => "1"
            ],
           [
               "permission_id" => "5",
              "role_id" => "1"
            ],
           [
               "permission_id" => "6",
              "role_id" => "1"
            ],
           [
               "permission_id" => "7",
              "role_id" => "1"
            ],
           [
               "permission_id" => "2",
              "role_id" => "2"
            ],
           [
               "permission_id" => "3",
              "role_id" => "2"
            ],
           [
               "permission_id" => "4",
              "role_id" => "2"
            ],
           [
               "permission_id" => "5",
              "role_id" => "2"
            ],
           [
               "permission_id" => "6",
              "role_id" => "2"
            ],
           [
               "permission_id" => "7",
              "role_id" => "2"
            ],

           [
               "permission_id" => "3",
              "role_id" => "4"
            ],
           [
               "permission_id" => "4",
              "role_id" => "4"
            ],
           [
               "permission_id" => "7",
              "role_id" => "4"
           ]
        ]);
    }
}
