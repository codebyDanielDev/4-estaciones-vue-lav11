<?php

namespace App\Listeners\Common\Auth;

use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogFailedlLogin
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
    public function handle(Failed $event): void
    {
        //
    }
}
