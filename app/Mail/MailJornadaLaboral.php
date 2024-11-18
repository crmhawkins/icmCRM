<?php

namespace App\Mail;

use App\Models\Company\CompanyDetails;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailJornadaLaboral extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The demo object instance.
     *
     * @var Demo
     */
    public $empleado;
    public $hora;
    public $fecha;
    public $empresa;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($empleado, $hora, $fecha)
    {
        $this->empleado = $empleado;
        $this->hora = $hora;
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
        ->subject("Jornada - ".$this->empresa->company_name)
        ->view('mails.mailJornadaLaboral');

        return $mail;
    }
}
