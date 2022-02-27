<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function authenticate(LoginRequest $request)
    {
        $user = User::findEmail($request->input('email'))->first();
        if ($user && Hash::check($request->input('password'), $user->password)) {
            $apiToken = base64_encode(Str::random(40));
            $user->api_token = $apiToken;
            $user->save();
            return response()->json(['status' => 'success', 'api_token' => $apiToken]);
        } else {
            return response()->json(['status' => 'fail', 'error'=> 'Email or password are not correct.'], 401);
        }
    }
}
