<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePremiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('premia', function (Blueprint $table) {
            $table->id();
            $table->integer('age')->nullable()->default(null);
            $table->integer('term')->nullable()->default(null);
            $table->float('sum_assured')->nullable()->default(null);
            $table->integer('company_id')->nullable()->default(null);
            $table->float('rate')->nullable()->default(106.25);
            $table->float('loadingcharge')->nullable()->default(null);
            $table->float('discount_on_sa')->nullable()->default(2);
           // $table->float('term_rider_rate')->nullable()->default(4.16);

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
        Schema::dropIfExists('premia');
    }
}
