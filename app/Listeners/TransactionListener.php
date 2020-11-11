<?php

namespace App\Listeners;

use App\Events\TransactionEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User as UserModel;

class TransactionListener
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
     * @param  TransactionEvent  $event
     * @return void
     */
    public function handle(TransactionEvent $event)
    {
        $user = UserModel::findOrFail(2);

        if (isset($user->seller)) {
            false;
        }

        return false;
    }
}
