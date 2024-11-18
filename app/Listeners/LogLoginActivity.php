<?php

namespace App\Listeners;

use App\Models\Logs\LogActions;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;

class LogLoginActivity
{
    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user; // Usuario que inició sesión

        LogActions::create([
            'tipo' => 1, // Tipo de acción
            'admin_user_id' => $user->id,
            'action' => 'Inicio de sesión',
            'description' => 'El usuario: '. $user->name .' ha iniciado sesión',
            'reference_id' => $user->id,
        ]);
    }
}
