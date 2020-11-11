<?php

namespace App\Events;

use App\Transaction;

class TransactionEvent extends Event
{
    public $transaction;

    /**
     * Create a new event instance.
     * @param  \App\Transaction  $transaction
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        //
        $this->transaction = $transaction;
    }
}
