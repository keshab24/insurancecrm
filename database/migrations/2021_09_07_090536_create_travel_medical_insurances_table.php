<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelMedicalInsurancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_medical_insurances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('KYCID');
            $table->integer('BRANCHID');
            $table->integer('DEPTID');
            $table->integer('CLASSID');
            $table->string('INSURED');
            $table->string('INSUREDADDRESS');
            $table->string('PASSPORTNO');
            $table->string('DOB');
            $table->double('TOTALDOLLARPREMIUM',15,3);
            $table->double('DOLLARRATE',15,3);
            $table->string('CURRENCY');
            $table->double('TOTALNC',15,3);
            $table->string('DTFROM');
            $table->string('DTTO');
            $table->bigInteger('PERIODOFINSURANCE');
            $table->string('VISITPLACE');
            $table->string('CONTACTNO');
            $table->string('OCCUPATION');
            $table->longText('REMARKS');
            $table->string('CAREOF');
            $table->integer('AGE');
            $table->boolean('ISDEPENDENT')->default(0);
            $table->string('RELATION');
            $table->double('COVIDCHARGEPREMIUM',15,3);
            $table->double('COVIDRATE',15,3);
            $table->double('DIRECTDISCOUNTRATE',15,3);
            $table->double('DIRECTDISCOUNT',15,3);
            $table->boolean('HASDIRECTDISCOUNT')->default(0);
            $table->integer('COVERTYPE');
            $table->integer('PLAN');
            $table->string('PACKAGE');
            $table->integer('ISANNUALTRIP');
            $table->integer('STAMPDUTY');
            $table->double('VATAMOUNT',15,3);
            $table->double('TOTALPAYABLEBYCLIENT',15,3);
            $table->string('MERCHANT_TRANS_NO');
            $table->string('MERCHANT_CODE');
            $table->string('MERCHANT_TRANS_DATE');
            $table->integer('status');
            $table->integer('status_step');
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
        Schema::dropIfExists('travel_medical_insurances');
    }
}
