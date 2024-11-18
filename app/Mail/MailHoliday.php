<?php

namespace App\Mail;

use App\Models\Company\CompanyDetails;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailHoliday extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The demo object instance.
     *
     * @var Demo
     */
    public $estado;
    public $empleado;
    public $empresa;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($estado, $empleado)
    {
        $this->estado = $estado;
        $this->empleado = $empleado;
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
        ->subject("Vacaciones - ".$this->empresa->company_name)
        ->view('mails.mailHoliday');

        return $mail;
    }
}
