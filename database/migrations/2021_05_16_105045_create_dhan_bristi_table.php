<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDhanBristiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dhanBristi', function (Blueprint $table) {
            $table->id();
            $table->integer('age');
            $table->integer('term');
            $table->double('sum_assured');
            $table->double('rate');
            $table->foreignId('loading_charge_id')->constrained('loading_charges');

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
        Schema::dropIfExists('dhanBristi');
    }
}
