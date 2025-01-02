<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function transactionHistory(Request $request)
    {
        $transactions = Transaction::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->with('user')
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction history retrieved successfully',
            'data' => TransactionResource::collection($transactions)
        ], 200);
    }

    public function requestCashout(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:10000',
            'remarks' => 'nullable|string',
            'ewallet_name' => 'required|string',
            'ewallet_number' => 'required|string',
        ]);

        $user = $request->user();
        if ($user->balance < $validated['amount']) {
            return response()->json([
                'status' => 'error',
                'message' => 'Insufficient balance',
            ], 400);
        }

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'type' => 'withdraw',
            'amount' => $validated['amount'],
            'status' => 'pending',
            'remarks' => $validated['remarks'],
            'ewallet_name' => $validated['ewallet_name'],
            'ewallet_number' => $validated['ewallet_number'],
        ]);

        $user->balance -= $validated['amount'];
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Cashout request created successfully',
            'data' => new TransactionResource($transaction)
        ], 201);
    }
}
