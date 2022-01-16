<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!auth()->attempt($request->only(['email', 'password']))) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => auth()->user(),
            'access_token' => $accessToken
        ]);
    }
}
