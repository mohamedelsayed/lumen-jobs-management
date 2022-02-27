<?php

namespace App\Http\Requests\Jobs;

use App\Http\Requests\BaseRequest;

class IndexRequest extends BaseRequest
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
            'perPage' => 'sometimes|integer|min:1|max:1000',
            'currentPage' => 'sometimes|integer|min:1|max:1000000',
        ];
    }
}
