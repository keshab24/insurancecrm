<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductFeatureRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_feature_rates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_feature_id')->unsigned();
            $table->float('rate');
            $table->integer('age_id');
            $table->integer('term_id');
            $table->foreign('product_feature_id')->references('id')->on('product_features');
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
        Schema::dropIfExists('product_feature_rates');
    }
}
