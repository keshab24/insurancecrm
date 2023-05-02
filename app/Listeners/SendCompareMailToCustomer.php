<?php

namespace App\Listeners;

use App\Events\CompareResultGenerated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCompareMailToCustomer implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CompareResultGenerated  $event
     * @return void
     */
    public function handle(CompareResultGenerated $event)
    {
        //
    }
}
