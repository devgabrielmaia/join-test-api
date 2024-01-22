<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(LoginRequest $request): LoginResource
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            throw new \RuntimeException('Invalid login credentials', 401);
        }
        $user = Auth::user();
        if (!$user) {
            throw new \RuntimeException('User not found', 404);
        }
        $token = $user->createToken('authToken')->plainTextToken;
        return new LoginResource((object)[
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(): JsonResponse
    {
        Auth::user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        return response()->json(['message' => 'Logged out']);
    }
}
