<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolicyTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policy_types', function (Blueprint $table) {
            $table->id();
            $table->integer('policy_cat_id')->unsigned()->nullable();
            $table->integer('subcat_id')->unsigned()->nullable();
            $table->string('type')->nullable()->default(null);
            $table->enum('is_active', [0, 1])->default(1);
            $table->timestamps();

          //  $table->foreign('policy_cat_id')->references('id')->on('policy_categories');
            //$table->foreign('subcat_id')->references('id')->on('policy_sub_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('policy_types');
    }
}
