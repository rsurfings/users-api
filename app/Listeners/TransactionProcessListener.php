<?php

namespace App\Listeners;

use App\Events\TransactionProcessEvent;
use Exception;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;

class TransactionProcessListener
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
     * @param  TransactionProcessEvent  $event
     * @return void
     */
    public function handle(TransactionProcessEvent $event)
    {
        $request = Http::get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
        if (!$request)
            throw new Exception;
        return $request;
    }
}
