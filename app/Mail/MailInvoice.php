<?php

namespace App\Mail;

use App\Models\Company\CompanyDetails;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailInvoice extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The demo object instance.
     *
     * @var Demo
     */
    public $filename;
    public $mailInvoice;
    public $empresa;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailInvoice, $filename)
    {
        $this->mailInvoice = $mailInvoice;
        $this->filename = $filename;
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
        ->subject("Factura - ".$this->empresa->company_name)
        ->view('mails.mailInvoice')
        ->attach($this->filename);

        return $mail;
    }
}
