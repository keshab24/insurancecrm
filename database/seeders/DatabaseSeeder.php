<?php

namespace Database\Seeders;

use App\Models\SocialLink;
use Database\Seeders\Basic\CompanySeeder;
use Database\Seeders\Basic\GeneralSettingSeeder;
/*use Database\Seeders\Basic\RolesSeeder;*/
use Database\Seeders\Basic\SocialMediaLinkSeeder;
use Database\Seeders\Basic\UsersSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $this->call(RolesTableSeeder::class);
//        $this->call(UsersTableSeeder::class);
        $this->call(PermissionSeeder::class);
//        $this->call(WhyUsSeeder::class);
//        $this->call(WhyDifferentSeeder::class);
//        $this->call(TestimonialSeeder::class);
//        $this->call(AssociationSeeder::class);
//        $this->call(AboutUsSeeder::class);
//        $this->call(ValuesSeeder::class);
//        $this->call(TeamSeeder::class);
//        $this->call(ProvinceTableSeeder::class);
//        $this->call(CityTableSeeder::class);
      //  $this->call(ModulesTableSeeder::class);
     //   $this->call(RoleModulesTableSeeder::class);
//        $this->call(PolicyTableSeeder::class);

        // Disable Foreign key check for emptying tables
        Schema::disableForeignKeyConstraints();

        // Basic Seeders
      //  $this->call(RolesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(SocialMediaLinkSeeder::class);
        $this->call(GeneralSettingSeeder::class);
        $this->call(CompanySeeder::class);


        $this->call(WhyUsSeeder::class);
        $this->call(WhyDifferentSeeder::class);
        $this->call(TestimonialSeeder::class);
        $this->call(AssociationSeeder::class);
        //        $this->call(ProvinceTableSeeder::class);
        //        $this->call(CityTableSeeder::class);
        //        $this->call(RolesTableSeeder::class);
        //        $this->call(UsersTableSeeder::class);
        //        $this->call(ModulesTableSeeder::class);
        //        $this->call(RoleModulesTableSeeder::class);
        //        $this->call(PolicyTableSeeder::class);

        // Enable Foreign key check
      //  Schema::enableForeignKeyConstraints();
    }
}
