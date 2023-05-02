<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImepayResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imepay_responses', function (Blueprint $table) {
            $table->id();
            $table->string('MerchantCode',10);
            $table->float('TranAmount');
            $table->string('RefId',20);
            $table->string('TokenId',20);
            $table->string('TransactionId',20);
            $table->string('Msisdn',20);
            $table->tinyInteger('ImeTxnStatus')->comment('0-Success,1-Failed,2-Error,3-Cancelled');
            $table->dateTime('RequestDate');
            $table->dateTime('ResponseDate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imepay_responses');
    }
}
