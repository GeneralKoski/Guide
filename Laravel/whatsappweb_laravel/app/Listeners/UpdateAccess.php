<?php

namespace App\Listeners;

use App\Events\NewAccess;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class UpdateAccess
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
    public function handle(NewAccess $event): void
    {
        $user = $event->user->getAttributes();
        DB::table('Users')
            ->where('id', '=', $user['id'])
            ->update(['last_access' => now()]);
    }
}