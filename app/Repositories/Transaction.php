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
        DB::beginTransaction();

        try {

            $transaction = new TransactionModel();
            $transaction->payee_id = $payeeId;
            $transaction->payer_id = $payerId;
            $transaction->value = $value;          

            $transaction->save();

            DB::commit();

            event(new TransactionProcessEvent($transaction));

            event(new TransactionProcessedEvent($transaction));

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
