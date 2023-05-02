<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Auth;
use Illuminate\Queue\SerializesModels;

class CompareResult extends Mailable
{
    use Queueable, SerializesModels;

    public $products;
    public $clientName;
    public $pdf;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($products, $clientName, $pdf)
    {
        $this->products = $products;
        $this->clientName = $clientName;
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@ebeema.com.np', 'Ebeema CRM')
            ->subject('Compare Result')
            ->cc([Auth::user()->email])
            ->attachData($this->pdf, 'compare-results.pdf', [
                'mime' => 'application/pdf',
            ])
            ->markdown('emails.compare.result');
    }
}
