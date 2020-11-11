<?php

namespace App\Listeners;

use App\Events\TransactionProcessedEvent;
use Exception;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;

class TransactionProcessedListener
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
     * @param  TransactionProcessedEvent  $event
     * @return void
     */
    public function handle(TransactionProcessedEvent $event)
    {
        //
        $request = Http::get('https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04');
        if(!$request)
            throw new Exception;
        return $request;
    }
}
