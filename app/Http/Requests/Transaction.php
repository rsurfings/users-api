<?php

namespace App\Http\Requests;

use App\Rules\IsAuthorized;
use App\Rules\IsAuthorizedTransaction;

class Transaction extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'payee_id' => 'required|exists:accounts,id',
            'payer_id' => [
                'required',
                'exists:accounts,id',
                new IsAuthorizedTransaction
            ],
            'value' => [
                'required',
                new IsAuthorized,
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'payee_id.exists' => 'Uma das contas informadas não existe.',
            'payer_id.exists' => 'Uma das contas informadas não existe.',
        ];
    }
}
