<?php

namespace App\Listeners;

use App\Events\NewAccess;
use App\Models\User;
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
        User::where('id', '=', $user['id'])
            ->update(['last_access' => now()]);
    }
}
