<?php

namespace App\Repositories;

use App\Events\TransactionEvent;
use App\Events\TransactionProcessedEvent;
use App\Events\TransactionProcessEvent;
use App\Transaction as TransactionModel;
use Illuminate\Support\Facades\DB;
use Exception;

class Transaction implements TransactionInterface
{

    /**
     * @inheritDoc
     */
    public function show(int $id): array
    {
        $transaction = TransactionModel::findOrFail($id);

        return $transaction->toArray();
    }

    /**
     * @inheritDoc
     */
    public function create(int $payeeId, int $payerId, float $value): array
    {
        //the transaction will be reversed in any case of inconsistency
        DB::beginTransaction();

        try {

            $transaction = new TransactionModel();
            $transaction->payee_id = $payeeId;
            $transaction->payer_id = $payerId;
            $transaction->value = $value;

            // seller only receive transfers, do not send money to anyone.
            event(new TransactionEvent($transaction));

            // triggers the query of the external authorizing service
            event(new TransactionProcessEvent($transaction));

            //transfer notification
            event(new TransactionProcessedEvent($transaction));

            $transaction->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        return [
            'id' => $transaction['id'],
            'payee_id' => $transaction->payee_id,
            'payer_id' => $transaction->payer_id,
            'value' => $transaction->value
        ];
    }
}
