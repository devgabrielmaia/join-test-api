<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegistrationRequest;
use App\Http\Resources\LoginResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function createUser(UserRegistrationRequest $request): LoginResource
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        $token = $user->createToken('authToken')->plainTextToken;
        return new LoginResource((object)[
            'user' => $user,
            'token' => $token,
        ]);
    }
}
