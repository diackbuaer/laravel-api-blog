<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $request->validated();
        $userData = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];

        $user = User::create($userData);
        $token = $user->createToken('news_app')->plainTextToken;
        return response([
            'user' => $user,
            'token' => $token
        ], 201);

    }

    public function login(LoginRequest $request)
    {
        $request->validated();

        $user = User::whereUsername($request->username)->first();
        if (!$user || !Hash::check($request->password, $user->password)){
            return response([
                'message' => __('Invalid credentials')
            ], 422);
        }
        $token = $user->createToken('news_app')->plainTextToken;
        return response([
            'user' => $user,
            'token' => $token
        ], 200);
    }
}
