<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\BaseFormRequest;

class SignInRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required',
        ];
    }
}
