<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Services\Payment;
use Illuminate\Http\Request;
use App\Http\Resources\WalletResource;

class WalletController extends Controller
{
    protected $paymentService;

    public function __construct(Payment $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $wallet = $user->wallet;

        return response()->json([
            'message' => 'Successfully retrieved wallet',
            'wallet' => new WalletResource($wallet),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'balance' => 'required|numeric|min:0',
        ]);

        $user = $request->user();
        $wallet = $user->wallet;
        $account = $user->account;

        $charge = $this->paymentService->charge([
            'email' => $user->email,
            'amount' => $request->balance,
            'bank' => [
                'account_number' => $account->account_number,
                'code' => $account->bank_code,
            ],
            'birthday' => $user->dob,
        ]);

        if ($charge->status !== true) {
            return response()->json([
                'message' => 'An error occurred while processing your request',
                'errors' => $charge->message,
            ], 400);
        }

        $wallet->update([
            'balance' => $wallet->balance + $request->balance,
        ]);

        return response()->json([
            'message' => 'Successfully added funds to wallet',
            'wallet' => new WalletResource($wallet),
        ]);
    }
}
