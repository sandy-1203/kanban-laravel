<?php


namespace App\Http\Requests\Api\Column;

use App\Http\Requests\Api\BaseFormRequest;

class UpdateColumnRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
        ];
    }
}
