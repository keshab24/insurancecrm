<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerPoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_policies', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('KYCID');
            $table->integer('BRANCHID')->default('1');
            $table->integer('DEPTID')->default('2');
            $table->integer('CLASSID')->nullable();
            $table->integer('CATEGORYID')->nullable();
            $table->string('TYPECOVER')->nullable();
            $table->string('BUSSOCCPCODE')->nullable();
            $table->string('MODEUSE')->nullable();
            $table->string('MAKEVEHICLEID')->nullable();
            $table->string('MAKEVEHICLE')->nullable();
            $table->string('HAS_TRAILOR')->nullable();
            $table->integer('MAKEMODELID')->nullable();
            $table->string('MODEL')->nullable();
            $table->integer('VEHICLENAMEID')->nullable();
            $table->string('NAMEOFVEHICLE')->nullable();
            $table->string('YEARMANUFACTURE')->nullable();
            $table->float('CCHP')->nullable();
            $table->float('PASSCAPACITY')->nullable();
            $table->float('CARRYCAPACITY')->nullable();
            $table->dateTime('REGDATE')->nullable();
            $table->float('EXPUTILITIESAMT')->nullable();
            $table->float('UTILITIESAMT')->nullable();
            $table->boolean('OGCPU')->default(1);
            $table->string('VEHICLENO')->nullable();
            $table->string('RUNNINGVEHICLENO')->nullable();
            $table->string('EVEHICLENO')->nullable();
            $table->string('ERUNNINGVEHICLENO')->nullable();
            $table->string('ENGINENO')->nullable();
            $table->string('CHASISNO')->nullable();
            $table->double('EODAMT',15,2)->nullable();
            $table->integer('NOOFVEHICLES')->nullable();
            $table->integer('NCDYR')->nullable();
            $table->float('PADRIVER')->nullable();
            $table->integer('NOOFEMPLOYEE')->nullable();
            $table->float('PACONDUCTOR')->nullable();
            $table->float('PACLEANER')->nullable();
            $table->integer('NOOFPASSENGER')->nullable();
            $table->float('PAPASSENGER')->nullable();
            $table->bigInteger('ESTCOST')->nullable();
            $table->float('OTHERSI')->nullable();
            $table->text('OTHERSIDESC')->nullable();
            $table->text('SHOWROOM')->nullable();
            $table->integer('Vehicleage')->nullable();
            $table->float('BASICPREMIUM_A')->nullable();
            $table->float('THIRDPARTYPREMIUM_B')->nullable();
            $table->float('DRIVERPREMIUM_C')->nullable();
            $table->float('HELPERPREMIUM_D')->nullable();
            $table->float('PASSENGERPREM_E')->nullable();
            $table->float('RSDPREMIUM_F')->nullable();
            $table->float('PAIDAMT')->nullable();
            $table->float('STAMPDUTY')->nullable();
            $table->float('VATRATE')->nullable();
            $table->float('VATAMT')->nullable();
            $table->string('MERCHANT_TRANS_NO')->nullable();
            $table->string('TRANS_DATE')->nullable();
            $table->string('MERCHANT_CODE')->nullable();
            $table->string('MERCHANT_PASSWORD')->nullable();
            $table->string('TOTAL_PREMIUM_BEFORE_VAT')->nullable();
            $table->longText('output')->nullable();
            $table->integer('status')->default(0);
            $table->integer('image_upload_status')->default(0);
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
        Schema::dropIfExists('customer_policies');
    }
}
