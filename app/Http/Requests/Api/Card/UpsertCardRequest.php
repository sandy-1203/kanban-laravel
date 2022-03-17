<?php


namespace App\Http\Requests\Api\Card;

use App\Http\Requests\Api\BaseFormRequest;

class UpsertCardRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => '',
            'title' => 'required',
            'column_id' => 'required',
            'description' => '',
        ];
    }
}
