<?php

namespace App\Http\Controllers\Api\V1\Owner;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\ExportResource;
use App\Models\Laundry;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Validator;

class TransactionController extends Controller
{
    public function export(Request $request, Laundry $laundry)
    {
        if(auth()->user()->tokenCan('ownerDo')||auth()->user()->tokenCan('employeeDo')){
            $validator = Validator::make($request->all(),[
                'year' => 'required',
                'month' => 'required'
            ]);

            if($validator->fails()){
                return response()->json([
                    'error' => 'Format Inputan Tidak Sesuai',
                    'message' => $validator->errors()
                ]);
            }
            
            $all = Transaction::query()
                ->whereBelongsTo($laundry)
                ->with(['user','laundry', 'catalog', 'parfume', 'user'])
                ->where('serial','LIKE','%'.$request->year.$request->month.'%')
                ->get();

            $revenue = Transaction::query()
                ->whereBelongsTo($laundry)
                ->where('serial','LIKE','%'.$request->year.$request->month.'%')
                ->get();

            $revenue = $revenue->sum('amount') + $revenue->sum('delivery_fee');

            return response()->json([
                'error' => null,
                'all' => ExportResource::collection($all),
                'revenue' => $revenue + 0
            ]);
        }
        return response()->json("Permintaan ditolak");
    }


    public function update(Request $request, Laundry $laundry, Transaction $transaction)
    {
        if((auth()->user()->tokenCan('employeeDo')||auth()->user()->tokenCan('ownerDo'))&& $transaction->laundry_id == $laundry->id){
            $validator = Validator::make($request->all(),[
                'status' => 'required|integer',
                'amount' => 'integer|nullable',
            ]);

            if($validator->fails()){
                return response()->json([
                    'error' => 'Format Inputan Tidak Sesuai',
                    'message' => $validator->errors()
                ]);
            }
            
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

    public function destroy(Laundry $laundry, Transaction $transaction)
    {
        // throw_if(
        //     !auth()->user()->tokenCan('shipping.delete')
        //         || auth()->id() != $laundry->user_id
        //         || $shippingRate->laundry_id != $laundry->id,
        //     ValidationException::withMessages(['shipping_rate' => 'Tidak dapat menghapus tarif ongkir!'])
        // );

        if(auth()->user()->tokenCan('ownerDo')
        && auth()->id() == $laundry->user_id
        && $transaction->laundry_id == $laundry->id){
            $transaction->delete();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Menghapus Transaksi!'
            ]);
        }
        return response()->json("Permintaan ditolak");
        
    }
}
