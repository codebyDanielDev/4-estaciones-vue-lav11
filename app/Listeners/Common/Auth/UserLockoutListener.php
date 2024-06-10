<?php

namespace App\Listeners\Common\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserLockoutListener
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
    public function handle(Lockout $event): void
    {
        //
    }
}
