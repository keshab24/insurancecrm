<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('lead_id')->nullable()->default(null);
            $table->integer('leadsource_id')->unsigned()->nullable();
            $table->integer('leadtype_id')->unsigned()->nullable();
            $table->string('sales_person_name')->nullable()->default(null);
            $table->string('customer_name')->nullable()->default(null);
            $table->string('province')->nullable()->default(null);
            $table->string('city')->nullable()->default(null);
            $table->string('street_ward')->nullable()->default(null);
            $table->string('phone')->unique()->nullable()->default(null);
            $table->string('email')->unique()->nullable()->default(null);
            $table->date('dob')->nullable()->default(null);
            $table->string('profession')->nullable()->default(null);
            $table->string('insurence_company_name')->nullable()->default(null);
            $table->string('policy_cat')->nullable()->default(null);
            $table->string('policy_sub_cat')->nullable()->default(null);
            $table->string('policy_type')->nullable()->default(null);
            $table->string('sun_insured')->nullable()->default(null);
            $table->integer('maturity_period')->nullable()->default(null);
            $table->integer('premium')->nullable()->default(null);
            $table->string('lead_transfer_req')->nullable()->default(null);
            $table->text('policy_doc')->nullable()->default(null);
            $table->text('identity_doc')->nullable()->default(null);

            $table->integer('province_id')->unsigned()->nullable();
            $table->integer('city_id')->unsigned()->nullable();

            $table->enum('is_active', [0, 1])->default(1);
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();

           // $table->foreign('province_id')->references('id')->on('provinces');
            //$table->foreign('city_id')->references('id')->on('cities');

            //$table->foreign('leadsource_id')->references('id')->on('leadsources');
            //$table->foreign('leadtype_id')->references('id')->on('lead_types');
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
        Schema::dropIfExists('leads');
    }
}
