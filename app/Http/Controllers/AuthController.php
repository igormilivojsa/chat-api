<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        // $request->validated()

        $user = User::create([
            'name' => $request->validated(['name']),
            'email' => $request->validated(['email']),
            'password' => bcrypt($request->validated(['password'])),
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response);
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->validated(['email']))->first();

        if (!$user || !Hash::check($request->validated(['password']), $user->password)) {
            return response([
                'message' => 'failed'
            ]);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}
