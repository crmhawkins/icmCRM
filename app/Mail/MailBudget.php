<?php

namespace App\Mail;

use App\Models\Company\CompanyDetails;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailBudget extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The demo object instance.
     *
     * @var Demo
     */
    public $atta;
    public $mailBudget;
    public $empresa;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailBudget,$atta)
    {
        $this->mailBudget = $mailBudget;
        $this->empresa = CompanyDetails::get()->first();

        $this->atta = $atta;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $empresa = CompanyDetails::get()->first();
        $email = $empresa->email;
        $mail = $this->from($email)
        ->subject("Presupuesto - ".$empresa->company_name)
        ->view('mails.mailBudget');

        foreach($this->atta as $filePath){
            $mail->attach($filePath);
        }

        return $mail;
    }
}
