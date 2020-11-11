<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use GuzzleHttp\Client;
use Exception;
use App\User as UserModel;

class IsAuthorizedTransaction extends BaseRule implements Rule
{

    /**
     * @inheritDoc
     */
    protected $statusCode = 401;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  int  $payer_id
     * @return bool
     */
    public function passes($attribute, $payer_id): bool
    {

        $user = UserModel::find($payer_id);
   
        if (isset($user->seller)) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Transação não autorizada';
    }
}
