<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\BaseFormRequest;

class SignUpRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6'
        ];
    }
}
