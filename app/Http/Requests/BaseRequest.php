<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Urameshibr\Requests\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class BaseRequest extends FormRequest
{
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator): void
    {
        $errors = (new ValidationException($validator))->errors();
        $data['status'] = 'fail';
        $data['errors'] = $errors;
        throw new HttpResponseException(
            response()->json($data, Response::HTTP_BAD_REQUEST)
        );
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        if (Request::route() && isset(Request::route()[2]) && Request::route()[2]) {
            $arr = Request::route()[2];
            foreach ($arr as $key => $value) {
                $data[$key] = $value;
            }
        }
        return $data;
    }
}
