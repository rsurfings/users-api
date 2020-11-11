<?php

namespace App\Listeners;

use App\Events\TransactionEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User as UserModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

        $payer_id = $event->transaction->getAttribute('payer_id');
        $user = UserModel::findOrFail($payer_id);

        if (isset($user->seller)) {
            throw new ModelNotFoundException;
        }

        return true;
    }
}
