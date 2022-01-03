<?php

namespace App\Http\Controllers\Api\Auth;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginJwtController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->all(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            $message = new ApiMessages('Unauthorized');
            return response()->json($message->getMessage(), 401);
        }

        return response()->json(['token' => $token], 200);
    }

    public function logout()
    {
        auth('api')->logout();
        $message = new ApiMessages('Logout Successfully');
        return response()->json($message->getMessage(), 200);
    }

    public function refresh()
    {
        $token = auth('api')->refresh();
        $message = new ApiMessages('Token Updated');
        return response()->json(['token' => $token, $message->getMessage()], 200);
    }
}
