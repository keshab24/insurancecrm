<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRateMigratesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rate_migrates', function (Blueprint $table) {
            $table->id();
            $table->float('rate');
            $table->integer('age_id');
            $table->integer('term_id');
            $table->integer('product_id');
            $table->integer('company_id');
            $table->integer('premium_paying_terms')->default(0);
            $table->integer('created_by');
            $table->softDeletes();
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
        Schema::dropIfExists('rate_migrates');
    }
}
