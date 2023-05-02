<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('code');
            $table->enum('type', ['life', 'non-life'])->nullable(false);
            $table->enum('category', ['endowment', 'pension', 'money-back', 'whole-life', 'term', 'retirement-pension', 'education', 'children', 'couple'])->nullable(false);
            // $table->foreign('companies_id')->references('id')->on('companies')->onDelete('CASCADE');
            $table->foreignId('company_id')->constrained('companies');
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
        Schema::dropIfExists('product');
    }
}
