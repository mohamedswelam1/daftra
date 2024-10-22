<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest; // Import the LoginRequest
use App\Traits\ApiResponse; // Import your custom trait
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponse;

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return $this->errorResponse(trans('auth.failed'), 401);
        }

        $user = $request->user();
        $token = $user->createToken('API Token')->plainTextToken;

        return $this->successResponse([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], trans('auth.login_success'));
    }
}
