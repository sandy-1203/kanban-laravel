<?php


namespace App\Http\Requests\Api\Board;

use App\Http\Requests\Api\BaseFormRequest;

class CreateBoardRequest extends BaseFormRequest
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
        ];
    }
}
