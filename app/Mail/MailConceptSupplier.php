<?php

namespace App\Mail;

use App\Models\Company\CompanyDetails;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailConceptSupplier extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The demo object instance.
     *
     * @var Demo
     */
    public $MailConceptSupplier;
    public $atta;
    public $empresa;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($MailConceptSupplier, $atta)
    {
        $this->MailConceptSupplier = $MailConceptSupplier;
        $this->atta = $atta;
        $this->empresa = CompanyDetails::get()->first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $mail = $this->from($this->MailConceptSupplier->gestorMail)
        ->subject("Orden de Compra - ".$this->empresa->company_name)
        ->view('mails.mailConceptSupplier');

        foreach($this->atta as $filePath){
            $mail->attach( $filePath);
        }

        return $mail;
    }
}
