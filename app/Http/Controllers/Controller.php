<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Response;

class Controller extends BaseController
{
    public function response($data = [])
    {
        $statusCode = Response::HTTP_OK;
        if (isset($data['statusCode'])) {
            $statusCode = $data['statusCode'];
            unset($data['statusCode']);
        } 
        return response($data, $statusCode);
    }
}
