<?php

namespace App\Repositories;

use App \ {
    Seller as SellerModel,
    Account,
    User
};
use Illuminate\Support\Facades\DB;
use Exception;

class Seller implements SellerInterface
{
    /**
     * @inheritDoc
     */
    public function create(
        int $userId,
        string $username,
        string $cnpj,
        string $fantasyName,
        string $socialName
    ): array {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($userId);
            $user->username = $username;
            $user->save();

            $account = Account::create();
            $seller = new SellerModel();
            $seller->account_id = $account->id;
            $seller->cnpj = $cnpj;
            $seller->fantasy_name = $fantasyName;
            $seller->social_name = $socialName;
            $seller = $user->seller()->save($seller);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return [
            'id' => $seller['id'],
            'user_id' => $userId,
            'username' => $username,
        ];
    }
}
