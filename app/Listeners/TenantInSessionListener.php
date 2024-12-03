<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Login;

class TenantInSessionListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        Log::debug('TenantInSessionListener constructed');
    }

    /**
     * Handle the event.
     * 
     * @param Login $event
     * @return void
     */
    public function handle(Login $event)
    {
        Log::debug('TenantInSessionListener handled');

    if ($event->user) {
        session()->put('tenant', $event->user->tenant_id); 
        Log::debug('Tenant ID definido na sessão: ' . $event->user->tenant_id);
    } else {
        Log::debug('Usuário não encontrado no evento Login.');
    }
    }
}
