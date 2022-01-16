<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VerifyEmailController extends Controller
{
    public function verify(Request $request, $user_id)
    {
        if (!$request->hasValidSignature()) {
            return response()->json([
                'message' => 'Invalid verification link'
            ], 400);
        }

        $user = User::where('id', $user_id)->first();

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return response()->json([
            'message' => 'Email verified successfully'
        ], 200);
    }

    public function resend()
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email already verified'
            ], 200);
        }

        auth()->user()->sendEmailVerificationNotification();

        return response()->json([
            "message" => "Email verification link sent on your email id"
        ]);
    }
}
