<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->insert([
            [
                'parent_id' => '0',
                'module_name' => 'User Management',
                'slug' => 'admin.privilege',
                'menu-class' => 'privilege',
                'icon' => 'fa fa-cog',
                'order_position' => 0,
                'is_active' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'parent_id' => '1',
                'module_name' => 'Role',
                'slug' => 'admin.privilege.role',
                'menu-class' => 'role',
                'icon' => 'fa fa-users',
                'order_position' => 1,
                'is_active' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'parent_id' => '1',
                'module_name' => 'User',
                'slug' => 'admin.privilege.user',
                'menu-class' => 'user',
                'icon' => 'fa fa-user',
                'order_position' => 2,
                'is_active' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'parent_id' => '0',
                'module_name' => 'Lead Categories',
                'slug' => 'admin.leadcategories',
                'menu-class' => 'leadcategories',
                'icon' => 'fa fa-user',
                'order_position' => 0,
                'is_active' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'parent_id' => '4',
                'module_name' => 'LeadSource',
                'slug' => 'admin.leadcategories.leadsource',
                'menu-class' => 'leadsource',
                'icon' => 'fa fa-user',
                'order_position' => 1,
                'is_active' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'parent_id' => '4',
                'module_name' => 'Lead Types',
                'slug' => 'admin.leadcategories.leadtypes',
                'menu-class' => 'leadtypes',
                'icon' => 'fa fa-user',
                'order_position' => 2,
                'is_active' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'parent_id' => '0',
                'module_name' => 'Policy Categories',
                'slug' => 'admin.policycategories',
                'menu-class' => 'policycategories',
                'icon' => 'fa fa-user',
                'order_position' => 0,
                'is_active' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'parent_id' => '7',
                'module_name' => 'Policy Sub Categories',
                'slug' => 'admin.policycategories.sub',
                'menu-class' => 'sub',
                'icon' => 'fa fa-user',
                'order_position' => 1,
                'is_active' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'parent_id' => '7',
                'module_name' => 'Policy Types',
                'slug' => 'admin.policycategories.type',
                'menu-class' => 'type',
                'icon' => 'fa fa-user',
                'order_position' => 1,
                'is_active' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'parent_id' => '0',
                'module_name' => 'Leads',
                'slug' => 'admin.leads',
                'menu-class' => 'leads',
                'icon' => 'fa fa-user',
                'order_position' => 0,
                'is_active' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
