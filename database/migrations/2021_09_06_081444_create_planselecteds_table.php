<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanselectedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planselecteds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('product');
            $table->integer('birth_date');
            $table->integer('birth_month');
            $table->integer('birth_year');
            $table->integer('age');
            $table->integer('term');
            $table->integer('sum_assured');
            $table->string('mop');
            $table->string('feature')->nullable();
            $table->float('premium');
            $table->float('bonus')->nullable();
            $table->integer('money_back')->nullable();
            $table->string('fname');
            $table->string('lname');
            $table->string('phone');
            $table->string('phone_2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planselecteds');
    }
}
