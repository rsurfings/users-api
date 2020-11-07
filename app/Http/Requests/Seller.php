<?php

namespace App\Http\Requests;

class Seller extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required',
            'username' => 'required',
            'cnpj' => 'required',
            'fantasy_name' => 'required',
            'social_name' => 'required',
        ];
    }
}
