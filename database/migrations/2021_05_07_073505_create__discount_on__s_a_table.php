<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountOnSATable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Discount_on_SA', function (Blueprint $table) {
            $table->id();
            $table->integer('first_amount');
            $table->integer('second_amount');
            $table->decimal('discount_value', 10, 4);
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('product_id')->constrained('product');
            $table->string('plan');
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
        Schema::dropIfExists('Discount_on_SA');
    }
}
