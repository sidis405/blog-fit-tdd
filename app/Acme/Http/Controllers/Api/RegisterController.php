<?php

namespace Acme\Http\Controllers\Api;

use JWTAuth;
use Acme\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends ApiController
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $credentials = $request->only('email', 'password');

        $token = JWTAuth::attempt($credentials);

        return response()->json([
            'result' => 'success',
            'user' => $user,
            'token' => $token
        ], 201);
    }
}
