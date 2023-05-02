<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMotorCalculationDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('motor_calculation_data', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('CATEGORYID')->nullable();
            $table->string('YEARMANUFACTURE')->nullable();
            $table->string('TYPECOVER')->nullable();
            $table->string('CCHP')->nullable();
            $table->float('CARRYCAPACITY')->nullable();
            $table->string('EXPUTILITIESAMT')->nullable();
            $table->float('compulsaryexcessamount')->nullable();
            $table->float('pool_premium')->nullable();
            $table->boolean('INCLUDE_TOWING')->default(0)->nullable();
            $table->boolean('PRIVATE_USE')->default(0)->nullable();
            $table->boolean('ISGOVERNMENT')->default(0)->nullable();
            $table->boolean('HASAGENT')->default(0)->nullable();
            $table->boolean('HAS_TRAILOR')->default(0)->nullable();
            $table->integer('BRANCHID')->nullable();
            $table->integer('CLASSID')->nullable();
            $table->integer('DEPTID')->nullable();
            $table->integer('BUSSOCCPCODE')->nullable();
            $table->double('PADRIVER', 15, 4)->nullable();
            $table->double('PAPASSENGER', 15, 4)->nullable();
            $table->integer('NOOFEMPLOYEE')->default(0)->nullable();
            $table->integer('Driver')->default(0)->nullable();
            $table->integer('PASSCAPACITY')->default(0)->nullable();
            $table->integer('PACONDUCTOR')->default(0)->nullable();
            $table->integer('NOOFPASSENGER')->default(0)->nullable();
            $table->float('BASICPREMIUM_A')->nullable();
            $table->float('THIRDPARTYPREMIUM_B')->nullable();
            $table->float('DRIVERPREMIUM_C')->nullable();
            $table->float('HELPERPREMIUM_D')->nullable();
            $table->float('PASSENGERPREM_E')->nullable();
            $table->float('RSDPREMIUM_F')->nullable();
            $table->float('NETPREMIUM')->nullable();
            $table->float('THIRDPARTYPREMIUM')->nullable();
            $table->integer('stamp')->nullable();
            $table->float('OTHERPREMIUM')->nullable();
            $table->float('TOTALVATABLEPREMIUM')->nullable();
            $table->float('TOTALNETPREMIUM')->nullable();
            $table->float('VAT')->nullable();
            $table->float('VATAMT')->nullable();
            $table->text('VEHICLENO')->nullable();
            $table->text('ENGINENO')->nullable();
            $table->text('CHASISNO')->nullable();
            $table->integer('MAKEVEHICLEID')->nullable();
            $table->integer('EXCLUDE_POOL')->nullable();
            $table->integer('NCDYR')->nullable();
            $table->integer('MAKEMODELID')->nullable();
            $table->integer('MODEL')->nullable();
            $table->integer('VEHICLENAMEID')->nullable();
            $table->double('EODAMT',15,3)->nullable();
            $table->string('MODEUSE')->nullable();
            $table->string('REGISTRATIONDATE')->nullable();
            $table->text('payment_token_details')->nullable();
            $table->string('payment_ref_id')->nullable();
            $table->text('payment_url')->nullable();
            $table->text('payment_output')->nullable();
            $table->text('bluebook_image')->nullable();
            $table->text('bike_image')->nullable();
            $table->integer('status')->default(0);
            $table->integer('image_upload_status')->default(0);
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
        Schema::dropIfExists('motor_calculation_data');
    }
}
