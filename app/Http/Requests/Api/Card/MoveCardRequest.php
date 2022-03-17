<?php


namespace App\Http\Requests\Api\Card;

use App\Http\Requests\Api\BaseFormRequest;

class MoveCardRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'newIndex' => 'required',
            'column_id' => 'required'
        ];
    }
}
