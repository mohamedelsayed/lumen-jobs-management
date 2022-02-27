<?php

namespace App\Http\Requests\Jobs;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer|exists:jobs,id',
            'title' => 'required|min:1|max:100',
            'description' => 'required|min:1|max:10000',
        ];
    }
}
