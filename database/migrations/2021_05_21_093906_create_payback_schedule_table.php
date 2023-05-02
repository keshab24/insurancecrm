<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaybackScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payback_schedule', function (Blueprint $table) {
            $table->id();
            $table->integer('term_year');
            $table->integer('payback_year');
            $table->decimal('rate');
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
        Schema::dropIfExists('payback_schedule');
    }
}
