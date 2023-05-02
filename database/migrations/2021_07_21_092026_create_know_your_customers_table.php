<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKnowYourCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('know_your_customers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('CATEGORYID')->nullable();
            $table->integer('INSUREDTYPE')->nullable();
            $table->integer('kycclassification')->nullable();
            $table->integer('KYCRiskCategory')->nullable();
            $table->string('INSUREDNAME_ENG')->nullable();
            $table->string('INSUREDNAME_NEP')->nullable();
            $table->integer('ZONEID')->nullable();
            $table->integer('DISTRICTID')->nullable();
            $table->integer('MUNICIPALITYCODE')->nullable();
            $table->integer('VDCCODE')->nullable();
            $table->string('ADDRESS')->nullable();
            $table->string('ADDRESSNEPALI')->nullable();
            $table->integer('WARDNO')->nullable();
            $table->integer('HOUSENO')->nullable();
            $table->integer('PLOTNO')->nullable();
            $table->string('TEMPORARYADDRESS')->nullable();
            $table->string('NTEMPORARYADDRESS')->nullable();
            $table->string('HOMETELNO')->nullable();
            $table->string('MOBILENO')->nullable();
            $table->string('EMAIL')->nullable();
            $table->integer('OCCUPATION')->nullable();
            $table->integer('INCOMESOURCE')->nullable();
            $table->string('PANNO')->nullable();
            $table->integer('GENDER')->nullable();
            $table->integer('MARITALSTATUS')->nullable();
            $table->dateTime('DATEOFBIRTH')->nullable();
            $table->string('CITIZENSHIPNO')->nullable();
            $table->integer('ISSUE_DISTRICT_ID')->nullable();
            $table->dateTime('ISSUEDATE')->nullable();
            $table->string('FATHERNAME')->nullable();
            $table->string('MOTHERNAME')->nullable();
            $table->string('GRANDFATHERNAME')->nullable();
            $table->string('GRANDMOTHERNAME')->nullable();
            $table->string('NFATHERNAME')->nullable();
            $table->string('NGRANDFATHERNAME')->nullable();
            $table->string('WIFENAME')->nullable();
            $table->text('photo')->nullable();
            $table->text('citfrntimg')->nullable();
            $table->text('citbackimg')->nullable();
            $table->text('cpmregimg')->nullable();
            $table->integer('BRANCHCODE')->nullable();
            $table->string('KYCNO')->nullable();
            $table->integer('ACCOUNTNAMECODE')->nullable();
            $table->integer('AREAID')->nullable();
            $table->integer('TOLEID')->nullable();
            $table->integer('is_verified')->default(0);
            $table->integer('KYCID')->nullable();
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
        Schema::dropIfExists('know_your_customers');
    }
}
