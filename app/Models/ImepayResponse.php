<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImepayResponse extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'MerchantCode', 'TranAmount','RefId', 'TranAmount', 'TokenId', 'TransactionId', 'Msisdn', 'ImeTxnStatus', 'RequestDate', 'ResponseDate'
    ];
}
