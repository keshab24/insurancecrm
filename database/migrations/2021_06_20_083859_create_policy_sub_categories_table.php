<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolicySubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policy_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->integer('policy_cat_id')->unsigned()->nullable();
            $table->string('subcat_name')->nullable()->default(null);
            $table->enum('is_active', [0, 1])->default(1);
            $table->timestamps();

           // $table->foreign('policy_cat_id')->references('id')->on('policy_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('policy_sub_categories');
    }
}
