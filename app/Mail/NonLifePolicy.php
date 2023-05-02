<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NonLifePolicy extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $policy;

    public function __construct($policy)
    {
        $this->policy = $policy;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@ebeema.com.np', 'Ebeema CRM')
            ->subject('NonLife Policy')
            ->cc(["azizdulal.ad@gmail.com","krishnakumarshrestha00@gmail.com"])
            ->markdown('emails.nonLife.policy');
    }
}
