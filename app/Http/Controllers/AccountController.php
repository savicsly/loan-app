<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\AccountResource;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $account = $request->user()->account;

        if (!$account) {
            return response()->json([
                'message' => 'User has no account',
            ], 404);
        }

        return response()->json([
            'message' => 'Successfully retrieved wallet',
            'account' => new AccountResource($account),
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'bank_code' => 'required|string|max:255',
        ]);

        $account = $request->user()->account()->create($request->all());

        return response()->json([
            'message' => 'Account created successfully',
            'account' => new AccountResource($account),
        ], 201);
    }
}
