<?php

namespace App\Listeners;

use App\Events\TransactionCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTransactionCreatedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TransactionCreated $event)
    {
        // Envía un correo electrónico utilizando un Mailable (TransactionCreatedMail)
        //Mail::to('recipient@example.com')->send(new TransactionCreatedMail($event->transaction));
        // aca colocar la logica
    }
}
