<?php

namespace App\Listeners;

use App\Events\RequestRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendAdminNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\RequestRegistered  $event
     * @return void
     */
    public function handle(RequestRegistered $event)
    {
        //
    }
}
