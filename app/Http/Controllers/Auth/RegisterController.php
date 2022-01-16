<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->safe()->except('password') + [
            'password' => bcrypt($request->password),
        ]);

        $user->wallet()->create([
            'balance' => 0.00,
        ]);

        $user->sendEmailVerificationNotification();



        return response()->json([
            'message' => 'User created successfully',
            'user' => new UserResource($user),
        ]);
    }
}
