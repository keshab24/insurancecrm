<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonusRateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Bonus_rate_for_endowment', function (Blueprint $table) {
            $table->id();
            $table->integer('first_year');
            $table->integer('second_year');
            // $table->integer('above');
            $table->double('term_rate', 100, 4);
            $table->unsignedBigInteger('company_id');
            $table->foreignId('product_id')->constrained('product');
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
        Schema::dropIfExists('Bonus_rate_for_endowment');
    }
}
