<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoadingChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loading_charges', function (Blueprint $table) {
            $table->id();
            $table->float('yearly')->nullable()->default(null);
            $table->float('half_yearly')->nullable()->default(null);
            $table->float('quarterly')->nullable()->default(null);
            $table->float('monthly')->nullable()->default(null);
            $table->float('premium_rate')->nullable()->default(null);
            $table->foreignId('company_id')->constrained('companies');
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
        Schema::dropIfExists('loading_charges');
    }
}
