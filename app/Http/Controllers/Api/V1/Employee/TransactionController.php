<?php

namespace App\Http\Controllers\Api\V1\Employee;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Laundry;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function update(Request $request, Laundry $laundry, Transaction $transaction)
    {
        if(auth()->user()->tokenCan('employeeDo')){
            $transaction->update([
                'amount' => $request->filled('amount') ? $request->amount : $transaction->amount,
                'status' => $request->status,
                'additional_information_laundry' => $request->filled('additional_information_laundry') ? $request->additional_information_laundry : $transaction->additional_information_laundry
            ]);

            $transaction->load(['user', 'laundry', 'catalog', 'parfume']);

            return TransactionResource::make($transaction);
        }
        return response()->json("Permintaan ditolak");
    }
}
