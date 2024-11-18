<?php

namespace App\Mail;

use App\Models\Company\CompanyDetails;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailTracking extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The mailTracking object instance.
     *
     * @var mailTracking
     */
    public $mailTracking;
    public $empresa;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailTracking)
    {
        $this->mailTracking = $mailTracking;
        $this->empresa = CompanyDetails::get()->first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->from($this->mailTracking->gestorMail)
        ->subject("Código de seguimiento de tu pedido - ".$this->empresa->company_name)
        ->view('mails.mailTrackingCode');

        return $mail;
    }
}
