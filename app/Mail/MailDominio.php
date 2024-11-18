<?php

namespace App\Mail;

use App\Models\Company\CompanyDetails;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailDominio extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The demo object instance.
     *
     * @var Demo
     */

    public $dominio;
    public $fecha;
    public $empresa;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($dominio, $fecha){
        $this->dominio = $dominio;
        $this->fecha = $fecha;
        $this->empresa = CompanyDetails::get()->first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->empresa->email;
        $mail = $this->from($email)
        ->subject("Dominio - ".$this->empresa->company_name)
        ->view('mails.mailDominio');

        return $mail;
    }
}
