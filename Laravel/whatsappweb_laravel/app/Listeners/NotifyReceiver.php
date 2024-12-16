<?php

namespace App\Listeners;

use App\Events\NewMessageSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyReceiver
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
    public function handle(NewMessageSent $event): void
    {
        $dati = $event->message->getAttributes();
        dd($dati);
    }
}
