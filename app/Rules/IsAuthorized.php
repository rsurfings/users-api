<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use GuzzleHttp\Client;
use Exception;

class IsAuthorized extends BaseRule implements Rule
{

    /**
     * @inheritDoc
     */
    protected $statusCode = 401;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  float  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {

        if ($value >= 100.00) {
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
